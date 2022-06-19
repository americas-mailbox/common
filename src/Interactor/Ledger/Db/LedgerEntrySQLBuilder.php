<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger\Db;

use AMB\SQLBuilder\AbstractSQLBuilder;

class LedgerEntrySQLBuilder extends AbstractSQLBuilder
{
    public function __invoke(array $selectedProperties = []): string
    {
        $this->setSelectedProperties($selectedProperties);

        return $this->sql();
    }

    public function from(): string
    {
        return "FROM ledger_entries AS ledgerEntry\n";
    }

    public function joins(): string
    {
        return <<<JOINS
LEFT JOIN ledgers ON ledgerEntry.ledger_id = ledgers.id
LEFT JOIN accounts ON accounts.ledger_id = ledgers.id
LEFT JOIN members ON members.account_id = accounts.id

JOINS;
    }

    public function selects(string $prefix = 'ledgerEntry', array $selectedProperties = []): array
    {
        return $this->gatherSelects($prefix, $selectedProperties);
    }

    public function sql(): string
    {
        return <<<SQL
SELECT
{$this->selectString('ledgerEntry', $this->selectedProperties)}
{$this->from()}
{$this->joins()}
SQL;
    }

    protected function transformerProperties(): array
    {
        return [
            'credit'          => 'credit',
            'date'            => 'date',
            'debit'           => 'debit',
            'description'     => 'description',
            'id'              => 'id',
            'referenceNumber' => 'reference_number',
            'runningBalance'  => 'running_balance',
        ];
    }
}
