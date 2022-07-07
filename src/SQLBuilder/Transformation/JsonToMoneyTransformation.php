<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

use AMB\SQLBuilder\TransformationInterface;
use IamPersistent\Money\Interactor\JsonToArray;
use IamPersistent\Money\Interactor\JsonToString;

final class JsonToMoneyTransformation implements TransformationInterface
{
    public function transform($value)
    {
        $transformed = (new JsonToArray)($value);
        $transformed['amount'] = (new JsonToString)($value);

        return $transformed;
    }
}
