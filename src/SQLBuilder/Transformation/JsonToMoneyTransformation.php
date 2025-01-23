<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

use AMB\SQLBuilder\TransformationInterface;
use OLPS\Money\Interactor\JsonToArray;
use OLPS\Money\Interactor\JsonToString;

final class JsonToMoneyTransformation implements TransformationInterface
{
    public function transform($value)
    {
        $transformed = (new JsonToArray)($value);
        $transformed['amount'] = (new JsonToString)($value);

        return $transformed;
    }
}
