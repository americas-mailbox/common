<?php

use Phinx\Migration\AbstractMigration;

class RenameDeliveryCompaniesTable extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('delivery_companies');
        $table
            ->rename('delivery_carriers')
            ->save();
        $builder = $this->getQueryBuilder();
        $builder
            ->update('delivery_carriers')
            ->set('active', 1)
            ->where(['name' => 'FedEx'])
            ->execute();
        $builder = $this->getQueryBuilder();
        $builder
            ->update('delivery_carriers')
            ->set('active', 1)
            ->where(['name' => 'US Postal Service'])
            ->execute();
    }

    public function down()
    {
        $table = $this->table('delivery_carriers');
        $table
            ->rename('delivery_companies')
            ->save();
    }
}
