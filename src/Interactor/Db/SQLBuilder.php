<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

abstract class SQLBuilder implements SQLBuilderInterface
{
    protected function gatherSelects(string $prefix, array $selectedProperties): array
    {
        if (empty($selectedProperties)) {
            $selectedProperties = $this->allProperties();
        }

        $selects = [];
        foreach ($selectedProperties as $property) {
            $selects[] = "{$prefix}.{$property} as `{$prefix}!{$property}`";
        }

        return $selects;
    }

    protected function selectString(string $prefix, array $selectedProperties): string
    {
        return implode(', ', $this->selects($prefix, $selectedProperties));
    }

    abstract protected function allProperties(): array;
}
