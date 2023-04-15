<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateMembershipStatus extends AbstractMigration
{
    public function change(): void
    {
        $this->updateActiveMembers();
        $this->updateClosedMembers();
        $this->updateSuspendedMembers();
        $this->updateUnverifiedMembers();

    }
    private function updateActiveMembers(): void
    {
        $builder = $this->getQueryBuilder();
        $builder
            ->update('memberships')
            ->set('status', 'ACTIVE')
            ->where(['active' => 1])
            ->execute();
    }

    private function updateClosedMembers(): void
    {
        $builder = $this->getQueryBuilder();
        $builder
            ->update('memberships')
            ->set('status', 'CLOSED')
            ->where(['active' => 0])
            ->execute();
    }

    private function updateSuspendedMembers(): void
    {
        $builder = $this->getQueryBuilder();
        $builder
            ->update('memberships')
            ->set('status', 'SUSPENDED')
            ->where(['active' => 1, 'suspended' => 1])
            ->execute();
    }

    private function updateUnverifiedMembers(): void
    {
        $builder = $this->getQueryBuilder();
        $builder
            ->update('memberships')
            ->set('status', 'UNVERIFIED')
            ->where(['active' => 2])
            ->execute();
    }
}
