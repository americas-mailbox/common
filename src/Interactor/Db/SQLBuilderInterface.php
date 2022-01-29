<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

interface SQLBuilderInterface
{
    public function __invoke(array $selectedProperties = []): string;
    public function joins(): string;
    public function selects(string $prefix, array $selectedProperties = []): array;
}
