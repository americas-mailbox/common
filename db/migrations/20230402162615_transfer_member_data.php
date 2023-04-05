<?php
declare(strict_types=1);

use AMB\Interactor\Db\FormatPhoneForPersistence;
use Phinx\Db\Table;
use Phinx\Migration\AbstractMigration;

final class TransferMemberData extends AbstractMigration
{
    private Table $memberTable;

    public function up(): void
    {
        $stmt = $this->query('SELECT * FROM members WHERE active = 1');
        $memberships = $stmt->fetchAll();
        $this->memberTable = $this->table('member_users');
        foreach ($memberships as $membership) {
            $this->addPrimaryMember($membership);
            $this->addAlternateMembers($membership);
//            $this->setMemberChangeoverSuccess($membership['member_id']);
        }
    }

    private function addAlternateMembers(array $membership): void
    {
        $altEmail = null;
        $altMembers = explode(',', $membership['alternate_name']);
        foreach ($altMembers as $altMember) {
            if (null === $altEmail) {
                $altEmail = $this->getAlternateEmail($membership);
                $altPhone = $this->formatPhoneNumber($membership['alt_phone']);
            }
            $member = [
                'email'         => $altEmail,
                'name'          => trim($altMember),
                'phone'         => $altPhone,
                'membership_id' => $membership['member_id'],
            ];
            $this->memberTable->insert($member)->saveData();
            $altEmail = '';
        }
    }

    private function addPrimaryMember(array $membership): void
    {
        $name = trim($membership['first_name'].' '.$membership['middle_name'].' '.$membership['last_name'].' '.
            $membership['suffix']);
        $member = [
            'email'         => $membership['email'],
            'name'          => $name,
            'phone'         => $this->formatPhoneNumber($membership['phone']),
            'membership_id' => $membership['member_id'],
        ];
        $this->memberTable->insert($member)->saveData();
    }

    private function getAlternateEmail(array $membership): string
    {
        if (trim($membership['alt_email']) !== trim($membership['email'])) {
            return trim($membership['alt_email']);
        }

        return '';
    }

    private function formatPhoneNumber($number): string
    {
        return (new FormatPhoneForPersistence)($number);
    }

    private function setMemberChangeoverSuccess($id): void
    {
        $this->getQueryBuilder()
            ->update('members')
            ->set('member_changeover_success', 1)
            ->where(['member_id' => $id])
            ->execute();
    }
}
