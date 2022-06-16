<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

final class FormatAddressForTable
{
    public function __invoke(array $data): string
    {
        if ('pickup' === $data['deliveryGroup']) {
            return 'Americas Mailbox, 514 Americas Way, Box Elder, SD';
        }

        $addressPieces = [];
        if (!empty($data['address'])) {
            $addressPieces[] = $data['address'];
        }
        if (!empty($data['suite'])) {
            $addressPieces[] = $data['suite'];
        }
        if (!empty($data['city'])) {
            $addressPieces[] = $data['city'];
        }
        if (!empty($data['state'])) {
            $addressPieces[] = $data['state'];
        }

        return implode(', ', $addressPieces);
    }
}
