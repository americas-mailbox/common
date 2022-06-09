<?php
declare(strict_types=1);

namespace AMB\Interactor\Address;

use AMB\Interactor\Address\Db\AddressSQLBuilder;
use AMB\SQLBuilder\AbstractFetchData;
use Doctrine\DBAL\Connection;

class FetchAddressesForMember extends AbstractFetchData
{
    public function __construct(
        AddressSQLBuilder $sqlBuilder,
        Connection $connection,
        AddressTransformer $addressTransformer,
    ) {
        parent::__construct($connection, $sqlBuilder, $addressTransformer);
        $this->prefix = 'address';
        $this->tableName = 'addresses';
    }
}
