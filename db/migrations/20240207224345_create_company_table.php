<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCompanyTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('companies');
        $table
            ->addColumn('name', 'char')
            ->addTimestamps()
            ->create();

        $data = [
            [
                'name' => 'Americas Mailbox',
            ],
        ];
        $this->table('companies')->insert($data)->save();
    }
}
