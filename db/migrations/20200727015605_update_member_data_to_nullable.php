<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateMemberDataToNullable extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('members')
            ->changeColumn('alt_email', 'char',
                [
                    'limit' => 255,
                    'null' => true,
                ]
            )
            ->changeColumn('alt_phone', 'char',
                [
                    'limit' => 60,
                    'null' => true,
                ]
            )
            ->changeColumn('comment', 'text', ['null' => true,])
            ->changeColumn('middle_name', 'char',
                [
                    'limit' => 129,
                    'null' => true,
                ]
            )
            ->changeColumn('suffix', 'char',
                [
                    'limit' => 128,
                    'null' => true,
                ]
            )
            ->removeColumn('last_mm_sync')
            ->removeColumn('mmpassword')
            ->changeColumn('officeid', 'char',
                [
                    'limit' => 10,
                    'null' => true,
                ]
            )
            ->changeColumn('shipinst', 'text',
                [
                    'null' => true,
                ]
            )
            ->update();
    }
}
