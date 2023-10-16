<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger\Db;

use Doctrine\DBAL\Connection;
use Infrastructure\SQLBuilder\AbstractFetchData;
use Infrastructure\SQLBuilder\Builder\LedgerEntrySQLBuilder;
use Infrastructure\SQLBuilder\Transformer\LedgerEntryEntityTransformer;

class FetchLedgerEntriesForMember extends AbstractFetchData
{
    public function __construct(
        LedgerEntrySQLBuilder $sqlBuilder,
        Connection $connection,
        LedgerEntryEntityTransformer $transformer,
    ) {
        parent::__construct($connection, $sqlBuilder, $transformer);
        $this->prefix = 'ledgerEntry';
        $this->tableName = 'ledger_entries';
    }

    protected function orderBy(): string
    {
        return "ORDER BY ledgerEntry.line DESC \n";
    }
}
