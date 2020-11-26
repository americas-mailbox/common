<?php

use Phinx\Migration\AbstractMigration;

class ChangeFedExEmailTemplateName extends AbstractMigration
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
        $this->getQueryBuilder()
            ->update('email_templates')
            ->set('name', 'staff.shipment_handler_failure')
            ->set('subject', 'Failure charging a member for a shipment')
            ->where(['name' => 'staff.fedex-failure'])
            ->execute();
    }
}
