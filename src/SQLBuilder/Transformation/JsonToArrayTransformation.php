<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

use AMB\SQLBuilder\TransformationInterface;
use IamPersistent\Money\Interactor\JsonToArray;

final class JsonToArrayTransformation implements TransformationInterface
{
    public function transform($value)
    {
        return (new JsonToArray)($value);
    }
}
