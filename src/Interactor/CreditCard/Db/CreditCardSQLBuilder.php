<?php
declare(strict_types=1);

namespace AMB\Interactor\CreditCard\Db;

use AMB\SQLBuilder\AbstractSQLBuilder;

class CreditCardSQLBuilder extends AbstractSQLBuilder
{
    public function __invoke(array $selectedProperties = []): string
    {
        $this->setSelectedProperties($selectedProperties);

        return $this->sql();
    }

    public function joins(): string
    {
        return <<<JOINS
    LEFT JOIN accounts ON creditCard.id = accounts.default_card_id

JOINS;
    }

    public function selects(string $prefix = 'creditCard', array $selectedProperties = []): array
    {
        $selects = $this->gatherSelects($prefix, $selectedProperties);
        if (empty($selectedProperties) || isset($selectedProperties['isDefault'])) {
            $selects[] = " accounts.default_card_id AS `{$prefix}!isDefault`";
        }

        return $selects;
    }

    public function sql(): string
    {
        return <<<SQL
SELECT
{$this->selectString('creditCard', $this->selectedProperties)}
FROM credit_cards AS creditCard
{$this->joins()}
SQL;
    }

    protected function transformerProperties(): array
    {
        return [
            'address'        => 'street_1',
            'brand'          => 'brand',
            'expirationDate' => 'expiration_date',
            'id'             => 'id',
            'lastFour'       => 'last_four',
            'nameOnCard'     => 'name_on_card',
            'suite'          => 'street_2',
            'title'          => 'title',
        ];
    }
}
