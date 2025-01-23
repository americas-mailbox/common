<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

use AMB\SQLBuilder\TransformationInterface;
use OLPS\Money\JsonToArray;

final class JsonToArrayTransformation implements TransformationInterface
{
    public function transform($value)
    {
        return (new JsonToArray)($value);
    }
}
