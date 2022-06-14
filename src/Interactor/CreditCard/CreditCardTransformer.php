<?php
declare(strict_types=1);

namespace AMB\Interactor\CreditCard;

use AMB\SQLBuilder\ExtractAndTransformGatheredData;
use AMB\SQLBuilder\Transformation\NumberToBool;
use AMB\SQLBuilder\TransformerInterface;

final class CreditCardTransformer implements TransformerInterface
{
    public function transform(array $data, string $prefix = 'address'): array
    {
        return (new ExtractAndTransformGatheredData)(
            $data,
            $prefix,
            [],
            $this->transformations(),
        );
    }

    private function transformations(): array
    {
        return [
            'isDefault' => new NumberToBool(),
        ];
    }
}
