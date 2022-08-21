<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice;

use Doctrine\DBAL\Connection;

final class NextInvoiceNumber
{
    public function __construct(
        private Connection $connection,
    ) {}

    public function get(): string
    {
        $this->connection->beginTransaction();
        $next = $this->connection->fetchOne($this->sqlForNext());
        $this->connection->executeStatement($this->sqlToIncrement());
        $this->connection->commit();

        return (string) $next;
    }

    private function sqlForNext(): string
    {
        return <<<SQL
SELECT invoice_number
FROM next_invoice_number_available;
SQL;
    }

    private function sqlToIncrement(): string
    {
        return <<<SQL
UPDATE next_invoice_number_available
SET invoice_number = invoice_number + 1
SQL;
    }
}
