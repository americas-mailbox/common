<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger\Db;

use AMB\SQLBuilder\AbstractTransformer;
use AMB\SQLBuilder\Transformation\JsonToMoneyTransformation;
use AMB\SQLBuilder\Transformation\JsonToNullableMoneyTransformation;

final class LedgerEntryTransformer extends AbstractTransformer
{
    protected function transformations(): array
    {
        return [
            'credit'         => new JsonToNullableMoneyTransformation(),
            'debit'          => new JsonToNullableMoneyTransformation(),
            'runningBalance' => new JsonToMoneyTransformation(),
        ];
    }
}
