<?php
declare(strict_types=1);

namespace AMB\Interactor\Invoice\Db;

use AMB\SQLBuilder\AbstractSQLBuilder;

class InvoiceOverviewSQLBuilder extends AbstractSQLBuilder
{
    public function __invoke(array $selectedProperties = []): string
    {
        $this->setSelectedProperties($selectedProperties);

        return $this->sql();
    }

    public function joins(): string
    {
        return '';
    }

    public function selects(string $prefix = 'InvoiceOverview', array $selectedProperties = []): array
    {
        return $this->gatherSelects($prefix, $selectedProperties);
    }

    public function sql(): string
    {
        return <<<SQL
SELECT
{$this->selectString('invoiceOverview', $this->selectedProperties)}
FROM invoices AS invoiceOverview
{$this->joins()}
SQL;
    }

    protected function transformerProperties(): array
    {
        return [
            'date'          => 'invoice_date',
            'description'   => 'header',
            'id'            => 'id',
            'invoiceNumber' => 'invoice_number',
            'total'         => 'total',
        ];
    }
}
