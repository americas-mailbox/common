<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddCategories extends AbstractMigration
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
        $categories = [
            [
                "id"   => 1,
                "name" => "invoice",
            ],
            [
                "id"   => 2,
                "name" => "ledger",
            ],
            [
                "id"   => 3,
                "name" => "newAccount",
            ],
            [
                "id"   => 4,
                "name" => "plan",
            ],
            [
                "id"   => 5,
                "name" => "planExtension",
            ],
        ];
        $this->table('categories')->insert($categories)->save();
    }
}
