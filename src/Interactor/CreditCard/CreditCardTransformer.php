<?php
declare(strict_types=1);

namespace AMB\Interactor\CreditCard;

use AMB\SQLBuilder\AbstractTransformer;
use AMB\SQLBuilder\Transformation\NumberToBool;

final class CreditCardTransformer extends AbstractTransformer
{
    protected function transformations(): array
    {
        return [
            'isDefault' => new NumberToBool(),
        ];
    }
}
