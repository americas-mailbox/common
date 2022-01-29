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
            'first_name',
            'last_name',
        ];
    }
}
