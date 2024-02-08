<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateCompanyLocationTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('company_locations');
        $table
            ->addColumn('name', 'char')
            ->addColumn('company_id', 'integer', ['signed' => false])
            ->addColumn('location_identifier', 'char')
            ->addTimestamps()
            ->create();

        $data = [
            [
                'company_id' => 1,
                'location_identifier' => 'SD',
                'name' => 'SD',
            ],
        ];
        $this->table('company_locations')->insert($data)->save();
    }
}
