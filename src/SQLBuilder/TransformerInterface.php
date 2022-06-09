<?php
declare(strict_types=1);

namespace AMB\SQLBuilder;

interface TransformerInterface
{
    public function transform(array $data, string $prefix): array;
}
