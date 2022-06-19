<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger\Db;

use AMB\SQLBuilder\AbstractTransformer;
use AMB\SQLBuilder\Transformation\JsonToArrayTransformation;
use AMB\SQLBuilder\Transformation\JsonToNullableArrayTransformation;

final class LedgerEntryTransformer extends AbstractTransformer
{
    protected function transformations(): array
    {
        return [
            'balance' => new JsonToArrayTransformation(),
            'credit'  => new JsonToNullableArrayTransformation(),
            'debit'   => new JsonToNullableArrayTransformation(),
        ];
    }
}
