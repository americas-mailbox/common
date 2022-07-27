<?php
declare(strict_types=1);

namespace AMB\SQLBuilder\Transformation;

use AMB\SQLBuilder\TransformationInterface;
use IamPersistent\Ledger\Interactor\DBal\MoneyToJson;
use IamPersistent\Money\Interactor\JsonToArray;
use IamPersistent\Money\Interactor\JsonToString;

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
