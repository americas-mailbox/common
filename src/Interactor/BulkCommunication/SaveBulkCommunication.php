<?php
declare(strict_types=1);

namespace AMB\Interactor\BulkCommunication;

use AMB\Entity\BulkCommunication;
use AMB\Interactor\Db\BoolToSQL;
use Doctrine\DBAL\Connection;
use Exception;
use IamPersistent\SimpleShop\Interactor\ObjectHasId;

final class SaveBulkCommunication
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function save(BulkCommunication $bulkCommunication)
    {
        if ((new ObjectHasId)($bulkCommunication)) {
            $this->update($bulkCommunication);

            return;
        }
        $this->insert($bulkCommunication);
    }

    private function insert(BulkCommunication $bulkCommunication): bool
    {
        $data = $this->prepDataForPersistence($bulkCommunication);
        try {
            $this->connection->beginTransaction();
            $response = $this->connection->insert('bulk_communications', $data);
            if (1 !== $response) {
                throw new Exception();
            }
            $id = (int)$this->connection->lastInsertId();
            $bulkCommunication->setId($id);
        } catch (Exception $e) {
            $this->connection->rollBack();

            return false;
        }

        return $this->connection->commit();
    }

    private function update(BulkCommunication $bulkCommunication)
    {
        $data = $this->prepDataForPersistence($bulkCommunication);
        try {
            $this->connection->beginTransaction();
            $response = $this->connection->update('bulk_communications', $data, ['id' => $bulkCommunication->getId()]);
        } catch (Exception $e) {
            $this->connection->rollBack();

            return false;
        }

        return $this->connection->commit();
    }

    private function prepDataForPersistence(BulkCommunication $bulkCommunication): array
    {
        return [
            'completed'     => (new BoolToSQL())($bulkCommunication->isCompleted()),
            'email_body'    => $bulkCommunication->getEmailBody(),
            'scheduled_for' => $bulkCommunication->getScheduledFor()->toDateTimeString(),
            'send_options'  => json_encode($bulkCommunication->getSendOptions()),
            'sms_body'      => $bulkCommunication->getSmsBody(),
            'subject'       => $bulkCommunication->getSubject(),
            'title'         => $bulkCommunication->getTitle(),
        ];
    }
}
