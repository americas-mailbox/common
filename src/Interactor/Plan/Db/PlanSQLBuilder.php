<?php
declare(strict_types=1);

namespace AMB\Interactor\Plan\Db;

use AMB\Interactor\Db\SQLBuilder;

final class PlanSQLBuilder extends SQLBuilder
{
    public function __invoke(array $selectedProperties = []): string
    {
        return <<<SQL
SELECT
{$this->selectString('plan', $selectedProperties)}
FROM rates_and_plans AS plan
{$this->joins()}
SQL;
    }

    public function joins(): string
    {
        return '';
    }

    public function selects(string $prefix = 'plan', array $selectedProperties = []): array
    {
        return $this->gatherSelects($prefix, $selectedProperties);
    }

    protected function allProperties(): array
    {
        return [
            'group',
        ];
    }

    protected function transformerProperties(): array
    {
        return [
            'group' => 'group',
        ];
    }
}
