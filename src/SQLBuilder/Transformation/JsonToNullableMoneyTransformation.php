<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

use AMB\SQLBuilder\TransformationInterface;

final class JsonToNullableMoneyTransformation implements TransformationInterface
{
    public function transform($value)
    {
        if (!$value) {
            return null;
        }

        return (new JsonToMoneyTransformation())->transform($value);
    }
}
