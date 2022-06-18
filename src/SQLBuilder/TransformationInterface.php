<?php
declare(strict_types=1);

namespace AMB\SQLBuilder;

interface TransformationInterface
{
    public function transform($value);
}
