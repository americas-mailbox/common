<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddBulkCommunicationTemplate extends AbstractMigration
{
    public function change(): void
    {
        $data = [
            'email_type' => 'member',
            'name'       => 'bulk-communication',
            'subject'    => '{{ subject }}',
        ];
        $this->table('email_templates')->insert($data)->save();
    }
}
