<?php

use Phinx\Migration\AbstractMigration;

class AddSystemProcessFailureEmailTemplate extends AbstractMigration
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
    public function change()
    {
        $data = [
            'email_type' => 'system',
            'name'       => 'system.process-failure',
            'subject'    => '{{ process }} failure',
        ];
        $this->table('email_templates')->insert($data)->save();
    }
}
