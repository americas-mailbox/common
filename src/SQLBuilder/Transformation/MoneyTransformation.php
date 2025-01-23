<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

use AMB\SQLBuilder\TransformationInterface;
use IamPersistent\Ledger\Interactor\DBal\MoneyToJson;
use OLPS\Money\JsonToArray;
use OLPS\Money\JsonToString;

final class MoneyTransformation implements TransformationInterface
{
    public function transform($money)
    {
        $value = (new MoneyToJson)($money);
        $transformed = (new JsonToArray)($value);
        $transformed['amount'] = (new JsonToString)($value);

        return $transformed;
    }
}
