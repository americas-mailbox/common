<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice\Db;

use AMB\SQLBuilder\AbstractFetchData;
use AMB\SQLBuilder\Builder\InvoiceOverviewSQLBuilder;
use AMB\SQLBuilder\Transformer\InvoiceOverviewEntityTransformer;
use Doctrine\DBAL\Connection;

class FetchInvoiceOverviewsForMember extends AbstractFetchData
{
    public function __construct(
        InvoiceOverviewSQLBuilder $sqlBuilder,
        Connection $connection,
        InvoiceOverviewEntityTransformer $invoiceOverviewTransformer,
    ) {
        parent::__construct($connection, $sqlBuilder, $invoiceOverviewTransformer);
        $this->prefix = 'invoiceOverview';
        $this->tableName = 'invoices';
    }

    public function getTotal(): int
    {
        $sql = "SELECT COUNT(*) FROM invoices as {$this->prefix} {$this->where()}";

        return (int) $this->connection->fetchOne($sql);
    }

    protected function orderBy(): string
    {
        return "ORDER BY invoice_date DESC \n";
    }
}
