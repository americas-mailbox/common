<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;
use Ramsey\Uuid\Uuid;

final class MigrateAdminsToLookupTable extends AbstractMigration
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
        $builder = $this->getQueryBuilder();
        $statement = $builder->select('*')->from('administrators')->execute();
        $admins = $statement->fetchAll('assoc');

        $this->table('admin_auth_lookups')->truncate();

        foreach ($admins as $admin) {
            $row = [
                'email'     => $admin['email'],
                'id'        => $this->getNewId(),
                'password'  => $admin['password'],
                'person_id' => $admin['id'],
                'username'  => $admin['username'],
            ];
            $this->table('admin_auth_lookups')->insert($row)->save();
        }
    }

    public function getNewId(): string
    {
        $id = Uuid::uuid4();

        return (string) $id;
    }
}
