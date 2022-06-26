<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Interactor\UpdateManager;
use Doctrine\DBAL\Connection;

final class CleanUpInCareOfs
{
    private const KEY_NAME = 'cleanUpInCareOfId';

    public function __construct(
        private Connection $connection,
        private UpdateManager $updateManager,
    ) {
    }

    public function cleanUp()
    {
        $addresses = $this->getAddressesForUpdating();
        foreach ($addresses as $address) {
            $addressId = (int) $address['id'];
//            $this->setInCareOf($address);
            $this->setAddress($address);
            $this->updateManager->set(self::KEY_NAME, $addressId + 1);
        }
    }

    private function getAddressesForUpdating(): array
    {
        $nextAddressId = (int) $this->updateManager->get(self::KEY_NAME);
        $sql = <<<SQL
SELECT street_1 as '0', street_2 as '1', street_3 as '2', id
FROM addresses
WHERE id >= $nextAddressId
AND (
    street_1 LIKE 'c/o%' OR
    street_2 LIKE 'c/o%' OR
    street_3 LIKE 'c/o%' 
    )
ORDER BY id ASC
SQL;

        return $this->connection->fetchAllAssociative($sql);
    }

    private function setAddress(array $address)
    {
        [$addressLine, $suite] = $this->determineAddressParts($address);

        $this->connection->update(
            'addresses',
            ['address' => $addressLine, 'suite' => $suite],
            ['id' => $address['id']]
        );
    }

    private function setInCareOf(array $address)
    {
        $inCareOf = $this->determineInCareOf($address);

        $this->connection->update('addresses', ['in_care_of' => $inCareOf], ['id' => $address['id']]);
    }

    private function determineInCareOf(array $address): string
    {
        foreach ([0, 1, 2] as $index) {
            if (str_starts_with(strtolower($address[$index]), 'c/o')) {
                $inCareOf = trim(substr($address[$index], 3));
                if (empty($inCareOf) && $index < 2) {
                    $inCareOf = $address[$index + 1];
                }

                return $inCareOf;
            }
        }

        return '';
    }

    private function determineAddressParts(array $address): array
    {
        $addressLine = '';
        $suite = '';
        foreach ([0, 1, 2] as $index) {
            if (str_starts_with(strtolower($address[$index]), 'c/o')) {
                if ($index === 2) {
                    $addressLine = $address[0];
                    $suite = $address[1];

                    break;
                }
                $addressLine = $address[$index + 1];
                if ($index < 1) {
                    $suite = $address[$index + 2];
                } else {
                    if (!$addressLine) {
                        $addressLine = $address[0];
                    } else {
                        $suite = $address[0];
                    }
                }
                break;
            }
        }

        return [trim((string)$addressLine), trim((string)$suite)];
    }
}
