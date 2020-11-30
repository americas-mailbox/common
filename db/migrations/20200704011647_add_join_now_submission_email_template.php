<?php

use Phinx\Migration\AbstractMigration;

class AddJoinNowSubmissionEmailTemplate extends AbstractMigration
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
            'email_type' => 'staff',
            'name'       => 'staff.join-now-submission',
            'subject'    => 'Join Now Submission',
        ];
        $this->table('email_templates')->insert($data)->save();
    }
}