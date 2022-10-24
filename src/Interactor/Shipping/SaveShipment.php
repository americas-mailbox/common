<?php
declare(strict_types=1);

namespace AMB\Interactor\Shipping;

use AMB\Entity\Shipping\Shipment;
use AMB\Interactor\Db\BoolToSQL;
use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Interactor\ObjectHasId;

final class SaveShipment
{
    public function __construct(
        private Connection $connection,
        private SaveDelivery $saveDelivery
    ) {}

    public function save(Shipment $shipment)
    {
        if ((new ObjectHasId)($shipment)) {
            $this->updateData($shipment);
        } else {
            $this->insertData($shipment);
        }
    }

    private function insertData(Shipment $shipment)
    {
        $data = $this->prepDataForPersistence($shipment);

        $response = $this->connection->insert('shipments', $data);
        if (1 === $response) {
            $id = $this->connection->lastInsertId();
            $shipment->setId($id);
        } else {

        }
    }

    private function updateData(Shipment $shipment)
    {
        $data = $this->prepDataForPersistence($shipment);

        $response = $this->connection->update('shipments', $data, ['id' => $shipment->getId()]);
    }

    private function prepDataForPersistence(Shipment $shipment): array
    {
        $delivery = $shipment->getDelivery();
        if ($delivery) {
            $this->saveDelivery->save($delivery);
            $deliveryId = $delivery->getId();
        } else {
            $deliveryId = 0;
        }
        $fulfilledDate = $shipment->getFulfilledDate() ? $shipment->getFulfilledDate()->toDateTimeString() : null;

        return [
            'address_id' => $shipment->getAddress()->getId(),
            'date' => $shipment->getDate()->toDateString(),
            'delivery_id' => $deliveryId,
            'delivery_method_id' => $shipment->getDeliveryMethod()->getId(),
            'fulfilled' => (new BoolToSQL)($shipment->isFulfilled()),
            'fulfilled_date' => $fulfilledDate,
            'fulfilled_ledger_item' => $shipment->getFulfilledLedgerItemId(),
            'member_id' => $shipment->getMember()->getId(),
            'vendor_id' => $shipment->getVendorId(),
        ];
    }
}
