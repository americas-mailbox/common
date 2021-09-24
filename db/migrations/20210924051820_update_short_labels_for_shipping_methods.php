<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UpdateShortLabelsForShippingMethods extends AbstractMigration
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
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_short_label', 'BM INT')
            ->where(['id' => 6])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_short_label', 'FX 2')
            ->where(['id' => 8])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_short_label', 'FX 3')
            ->where(['id' => 9])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_short_label', 'FX G')
            ->where(['id' => 10])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'FedEx International')
            ->set('internal_short_label', 'FX INT')
            ->where(['id' => 11])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'USPS Express')
            ->set('internal_short_label', 'EX 2')
            ->where(['id' => 14])
            ->execute();
        $this->getQueryBuilder()
            ->update('delivery_methods')
            ->set('internal_label', 'USPS International')
            ->set('internal_short_label', 'USPS INT')
            ->where(['id' => 16])
            ->execute();
    }
}
