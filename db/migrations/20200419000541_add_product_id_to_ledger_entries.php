<?php

use Phinx\Migration\AbstractMigration;

class AddProductIdToLedgerEntries extends AbstractMigration
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
        $builder = $this->getQueryBuilder();
        $statement = $builder->select('*')->from('products')->execute();
        $skus = $statement->fetchAll();

        foreach ($skus as $sku) {
            $sql = <<<SQL
UPDATE ledger_entries
SET product_id = '$sku[0]'
WHERE reference_number="$sku[2]";
SQL;
            $this->query($sql);
        }

        $sql = <<<SQL
UPDATE ledger_entries
SET product_id = '74'
WHERE description='Add money to fund' 
OR description LIKE 'Postage charge.%';
SQL;
        $this->query($sql);
    }
}
