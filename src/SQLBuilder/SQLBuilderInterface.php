<?php
declare(strict_types=1);

namespace AMB\SQLBuilder;

interface SQLBuilderInterface
{
    public function __invoke(array $selectedProperties = []): string;
    public function from(): string;
    public function joins(): string;
    public function selects(string $prefix, array $selectedProperties = []): array;
    public function setSelectedProperties(array $selectedProperties = []): self;
    public function sql(): string;
}
