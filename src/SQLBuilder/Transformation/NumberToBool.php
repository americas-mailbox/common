<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

use AMB\SQLBuilder\TransformationInterface;

final class NumberToBool implements TransformationInterface
{
    public function transform($value)
    {
        return (bool)((int)$value);
    }
}
