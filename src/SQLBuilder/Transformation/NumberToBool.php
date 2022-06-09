<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

final class NumberToBool
{
    public function transform($value)
    {
        return (bool)((int)$value);
    }
}
