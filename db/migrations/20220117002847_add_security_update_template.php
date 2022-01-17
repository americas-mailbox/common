<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class AddSecurityUpdateTemplate extends AbstractMigration
{
    public function change(): void
    {
        $data = [
            'email_type' => 'member',
            'name'       => 'member.security-update',
            'subject'    => 'We are updating our site!',
        ];
        $this->table('email_templates')->insert($data)->save();
    }
}
