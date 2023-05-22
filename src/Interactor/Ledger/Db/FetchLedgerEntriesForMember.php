<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger\Db;

use AMB\SQLBuilder\AbstractFetchData;
use AMB\SQLBuilder\Builder\LedgerEntrySQLBuilder;
use AMB\SQLBuilder\Transformer\LedgerEntryEntityTransformer;
use Doctrine\DBAL\Connection;

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
