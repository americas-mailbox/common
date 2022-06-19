<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

use AMB\SQLBuilder\TransformationInterface;
use IamPersistent\Money\Interactor\JsonToArray;

final class JsonToNullableArrayTransformation implements TransformationInterface
{
    public function transform($value)
    {
        return $value ? (new JsonToArray)($value) : null;
    }
}
