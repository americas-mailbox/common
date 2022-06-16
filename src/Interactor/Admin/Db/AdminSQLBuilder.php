<?php
declare(strict_types=1);

namespace AMB\Interactor\Admin\Db;

use AMB\Interactor\Db\SQLBuilder;

final class AdminSQLBuilder extends SQLBuilder
{
    public function __invoke($selectedProperties = []): string
    {
       return '';
    }

    public function joins(): string
    {
        return '';
    }

    public function selects(
        string $prefix = 'administrators',
        array $selectedProperties = []
    ): array
    {
        return $this->gatherSelects($prefix, $selectedProperties);
    }

    protected function allProperties(): array
    {
        return [
            'email',
            'first_name',
            'id',
            'last_name',
            'role',
            'status',
            'username',
        ];
    }

    protected function transformerProperties(): array
    {
        return [
            'email'      => 'email',
            'first_name' => 'first_name',
            'id'         => 'id',
            'last_name'  => 'last_name',
            'role'       => 'role',
            'status'     => 'status',
            'username'   => 'username',
        ];
    }
}
