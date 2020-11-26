<?php

use Phinx\Migration\AbstractMigration;

class AddNotifyAutoTopUpTemplates extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $data = [
            [
                'email_type'  => 'staff',
                'name' => 'staff.automatic-top-ups',
                'subject' => 'Automatic Top Ups Notice for {{ today }}',
            ],
            [
                'email_type'  => 'member',
                'name' => 'member.account.topped-up',
                'subject' => '#{{ pmb }} {{ fullName }} / Your Account Has Been Automatically Topped Up',
            ],
        ];

        $this->table('email_templates')->insert($data)->save();
    }
}
