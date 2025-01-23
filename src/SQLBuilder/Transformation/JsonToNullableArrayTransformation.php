<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

use AMB\SQLBuilder\TransformationInterface;
use OLPS\Money\JsonToArray;

final class JsonToNullableArrayTransformation implements TransformationInterface
{
    public function transform($value)
    {
        return $value ? (new JsonToArray)($value) : null;
    }
}
