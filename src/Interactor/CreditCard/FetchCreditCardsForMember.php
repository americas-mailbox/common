<?php
declare(strict_types=1);

namespace AMB\Interactor\CreditCard;

use AMB\Interactor\CreditCard\Db\CreditCardSQLBuilder;
use AMB\SQLBuilder\AbstractFetchData;
use Doctrine\DBAL\Connection;

class FetchCreditCardsForMember extends AbstractFetchData
{
    public function __construct(
        CreditCardSQLBuilder $sqlBuilder,
        Connection $connection,
        CreditCardTransformer $creditCardTransformer,
    ) {
        parent::__construct($connection, $sqlBuilder, $creditCardTransformer);
        $this->prefix = 'creditCard';
        $this->tableName = 'credit_cards';
    }
}
