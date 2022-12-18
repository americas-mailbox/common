<?php
declare(strict_types=1);

namespace AMB\Interactor\Auth;

use AMB\Entity\Member;
use AMB\Entity\MemberStatus;
use AMB\Interactor\Log\LogMemberLogin;
use AMB\Interactor\Member\FindMemberByPmb;
use App\Authentication\Entity\AuthLookup;
use App\Authentication\Entity\NewAuthLookup;
use App\Authentication\Interactor\AuthenticateUsernamePassword;
use App\Authentication\Interactor\CreateAuthLookup;
use App\Authentication\Interactor\UpdateAuthLookup;
use App\Authentication\Interactor\UpdatePasswordByUsername;
use App\Message\Mutation\AuthenticateMemberMessage;
use Doctrine\DBAL\Connection;

final class AuthenticateMember
{
    public function __construct(
        private AuthenticateUsernamePassword $authenticateMember,
        private Connection $connection,
        private CreateAuthLookup $createAuthLookup,
        private FindMemberByPmb $findMember,
        private LogMemberLogin $log,
        private UpdateAuthLookup $updateAuthLookup,
    ) { }

    public function authenticate($username, $password): array
    {
        if ($this->isMemberNeedingReset($username)) {
            return $this->authenticateAndUpdate($username, $password);
        }

        return $this->authenticateMember($username, $password);
    }

    private function isMemberNeedingReset($username): bool
    {
        $sql = <<<SQL
SELECT is_needing_password_reset
FROM members
WHERE pmb = $username
SQL;
        $result = (int) $this->connection->fetchOne($sql);

        return $result === 1;
    }
    private function addMemberToAuthentication($username, $password, Member $member)
    {
        $authLookup = new NewAuthLookup(
            $member->getEmail(),
            $password,
            $username,
        );
        $lookupId = $this->createAuthLookup->create($authLookup);
        $data = [
            'user_id' => $member->getId(),
        ];
        $this->updateAuthLookup->update($lookupId, $data);
    }

    private function authenticateAndUpdate($username, $password): array
    {
        $member = $this->findMember->find($username);
        if (!$member) {
            return [
                'message' => 'That PMB cannot be found',
                'success' => false,
            ];
        }
        if (!$this->legacyAuthentication($member, $password)) {
            return [
                'message' => "That isn't the password we have on file",
                'success' => false,
            ];
        }
        $this->updateMemberAuthentication($username, $password, $member);

        $this->authenticateMember($username, $password);
    }

    private function authenticateMember($username, $password): array
    {
        $authResponse = $this->authenticateMember->authenticate($username, $password);
        $this->checkAuthorization($username, $authResponse);

        return  $authResponse['success'] ?
            $this->formatSuccessResponse($authResponse) :
            $this->formatFailureResponse($authResponse);
    }

    private function checkAuthorization($username, array &$authResponse)
    {
        $member = $this->findMember->find($username);
        if ($member->getMemberStatus()->equals(MemberStatus::CLOSED)) {
            $authResponse['message'] = 'Your account is no longer active. Contact us to reactive your account.';
            $authResponse['success'] = false;

            return;
        }
        if ($member->getMemberStatus()->equals(MemberStatus::UNVERIFIED)) {
            $authResponse['message'] = 'Your account is in the verification process. Once we are finished, you will be notified.';
            $authResponse['success'] = false;
        }
    }

    private function formatFailureResponse(array $data): array
    {
        //        $this->log->log("Failed login attempt: {$data['message']}");

        return [
            'message' => $data['message'],
            'success' => false,
        ];
    }

    private function formatSuccessResponse(array $data): array
    {
        $pmb = (string)$data['user']->getPmb();

        //        $this->log->log("Successfully logged in PMB#{$pmb}");
        return [
            'user'            => [
                'firstName'   => $data['user']->getFirstName(),
                'id'          => (string)$data['user']->getId(),
                'isSuspended' => $data['user']->isSuspended(),
                'lastName'    => $data['user']->getLastName(),
                'plan'        => [
                    'group' => $data['user']->getMemberPlan()->getPlan()->getGroup(),
                    'title' => $data['user']->getMemberPlan()->getPlan()->getTitle(),
                ],
                'pmb'         => $pmb,
                'role'        => $data['user']->getMemberPlan()->getPlan()->getGroup(),
                'status'      => $data['user']->getMemberStatus()->getValue(),
                'username'    => $pmb,
            ],
            'expiresAt'       => $data['expiresAt'],
            'jwt'             => $data['jwt'],
            'success'         => $data['success'],
            'useNewDashboard' => $data['user']->useNewDashboard(),
        ];
    }

    private function legacyAuthentication(Member $member, $password): bool
    {
        $sql = <<<SQL
SELECT password 
FROM members 
WHERE pmb = {$member->getPMB()};
SQL;
        $memberPassword = $this->connection->fetchOne($sql);

        return sha1($password) === $memberPassword;
    }

    private function removeOldPasswordFromMember($pmb)
    {
        $sql = "UPDATE members SET password = '' WHERE pmb = {$pmb};";
        $this->connection->executeQuery($sql);
    }

    private function setNeedingResetToFalse($pmb)
    {
        $sql = "UPDATE members SET is_needing_password_reset = 0 WHERE pmb = $pmb;";
        $this->connection->executeQuery($sql);
    }

    private function updateMemberAuthentication($username, $password, Member $member)
    {
        $this->addMemberToAuthentication($username, $password, $member);
        //        $this->resetPasswordInNewSystem($message);
        //        $this->removeOldPasswordFromMember($message);
        $this->setNeedingResetToFalse($username);
        $this->authenticateMember($username, $password);
    }
}
