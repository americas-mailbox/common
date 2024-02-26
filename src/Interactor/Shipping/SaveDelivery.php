<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Entity\Shipping\Delivery;
use Doctrine\DBAL\Connection;
use IamPersistent\Ledger\Interactor\DBal\MoneyToJson;

final class SaveDelivery
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function save(Delivery $delivery)
    {
        if ($delivery->getId()) {
            // update
            $this->updateData($delivery);
        } else {
            $this->insertData($delivery);
        }
    }

    private function insertData(Delivery $delivery)
    {
        $data = $this->prepDataForPersistence($delivery);

        $response = $this->connection->insert('deliveries', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $delivery->setId($id);
        } else {

        }
    }

    private function updateData(Delivery $delivery)
    {
        $data = $this->prepDataForPersistence($delivery);

        $response = $this->connection->update('deliveries', $data, ['id' => $delivery->getId()]);
    }

    private function prepDataForPersistence(Delivery $delivery): array
    {
        $carrier = $delivery->getCarrier();
        $charges = $delivery->getCharges();
        $size = $delivery->getPackageSize();
        $height = $size ? $size->getHeight() : null;
        $length = $size ? $size->getLength() : null;
        $width = $size ? $size->getWidth() : null;
        $sizeUnit = $size ? $size->getUnit() : null;
        $weight = $delivery->getPackageWeight();
        $moneyToJson = (new MoneyToJson());

        return [
            'carrier_id'         => $carrier->getId(),
            'charges_base'       => $moneyToJson($charges->getBase()),
            'charges_surcharges' => $moneyToJson($charges->getSurcharges()),
            'charges_total'      => $moneyToJson($charges->getTotal()),
            'height'             => $height,
            'length'             => $length,
            'package_type'       => $delivery->getPackageCode(),
            'service_code'       => $delivery->getServiceCode(),
            'size_unit'          => $sizeUnit,
            'tracking_number'    => $delivery->getTrackingNumber(),
            'weight_amount'      => $weight->getAmount(),
            'weight_type'        => $weight->getType(),
            'weight_unit'        => $weight->getUnit(),
            'width'              => $width,
            'zone'               => $delivery->getZone(),
        ];
    }
}
