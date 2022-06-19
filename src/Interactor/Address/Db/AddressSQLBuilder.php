<?php
declare(strict_types=1);

namespace AMB\Interactor\Address\Db;


use AMB\SQLBuilder\AbstractSQLBuilder;

class AddressSQLBuilder extends AbstractSQLBuilder
{
    public function __invoke(array $selectedProperties = []): string
    {
        $this->setSelectedProperties($selectedProperties);

        return $this->sql();
    }

    public function from(): string
    {
        return "FROM addresses AS address\n";
    }

    public function joins(): string
    {
        return '';
    }

    public function selects(string $prefix = 'address', array $selectedProperties = []): array
    {
        return $this->gatherSelects($prefix, $selectedProperties);
    }

    public function sql(): string
    {
        return <<<SQL
SELECT
{$this->selectString('address', $this->selectedProperties)}
{$this->from()}
{$this->joins()}
SQL;
    }

    protected function transformerProperties(): array
    {
        return [
            'address'      => 'address',
            'addressee'    => 'addressee',
            'city'         => 'city',
            'country'      => 'country',
            'id'           => 'id',
            'inCareOf'     => 'in_care_of',
            'isVerified'   => 'verified',
            'locationName' => 'location_name',
            'membershipId' => 'membership_id',
            'plus4'        => 'plus4',
            'postcode'     => 'post_code',
            'state'        => 'state',
            'suite'        => 'suite',
        ];
    }
}
