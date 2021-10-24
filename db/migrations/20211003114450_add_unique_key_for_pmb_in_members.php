<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddUniqueKeyForPmbInMembers extends AbstractMigration
{

    public function up()
    {
        $this->table('members')
            ->addIndex('pmb', ['unique' => true, 'name' => 'idx_unq_members_pmb'])
            ->save();
    }

    /**
     * Migrate Down.
     */
    public function down()
    {
        $this->table('members')->removeIndexByName('idx_unq_members_pmb')->save();
    }
}
