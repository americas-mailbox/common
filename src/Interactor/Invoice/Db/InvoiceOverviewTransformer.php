<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice\Db;

use AMB\SQLBuilder\AbstractTransformer;
use AMB\SQLBuilder\Transformation\JsonToArrayTransformation;

final class InvoiceOverviewTransformer extends AbstractTransformer
{
    protected function transformations(): array
    {
        return [
            'total' => new JsonToArrayTransformation(),
        ];
    }
}
