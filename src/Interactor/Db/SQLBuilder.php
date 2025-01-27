<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

abstract class SQLBuilder implements SQLBuilderInterface
{
    protected function gatherSelects(string $prefix, array $selectedProperties): array
    {
        $transformerProperties = $this->transformerProperties();

        if (empty($selectedProperties)) {
            $selectedProperties = array_keys($transformerProperties);
        }

        $selects = [];
        foreach ($selectedProperties as $property) {
            $selects[] = "{$prefix}.{$transformerProperties[$property]} as `{$prefix}!{$property}`";
        }

        return $selects;
    }

    protected function selectString(string $prefix, array $selectedProperties): string
    {
        return implode(', ', $this->selects($prefix, $selectedProperties));
    }

    abstract protected function transformerProperties(): array;

    abstract protected function allProperties(): array;
}
