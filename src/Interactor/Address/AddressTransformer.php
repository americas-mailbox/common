<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\SQLBuilder\AbstractTransformer;
use AMB\SQLBuilder\Transformation\NumberToBool;

final class AddressTransformer extends AbstractTransformer
{
    protected function transformations(): array
    {
        return [
            'isVerified' => new NumberToBool(),
        ];
    }
}
