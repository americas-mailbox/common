<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class UspsTableCleanup extends AbstractMigration
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
        if ($this->hasTable('usps_flat_rates')) {
            $this->table('usps_flat_rates')->drop()->save();
        }
        if ($this->hasTable('usps_shipping_rates')) {
            $this->table('usps_shipping_rates')->drop()->save();
        }
    }
}
