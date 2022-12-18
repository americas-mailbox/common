<?php
declare(strict_types=1);

namespace AMB\Factory\Interactor\Auth;

use AMB\Interactor\Auth\AuthenticateMember;
use AMB\Interactor\Log\LogMemberLogin;
use AMB\Interactor\Member\FindMemberByPmb;
use App\Handler\Mutation\AuthenticateMemberHandler;
use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class AuthenticateMemberFactory
{
    public function __invoke(ContainerInterface $container): AuthenticateMember
    {
        $authenticate = $container->get('member.authentication');
        $connection = $container->get(Connection::class);
        $createAuthLookup = $container->get('member.createAuthLookup');
        $findMember = $container->get(FindMemberByPmb::class);
        $log = $container->get(LogMemberLogin::class);
        $updateAuthLookup = $container->get('member.updateAuthLookup');

        return new AuthenticateMember(
            $authenticate,
            $connection,
            $createAuthLookup,
            $findMember,
            $log,
            $updateAuthLookup
        );
    }
}
