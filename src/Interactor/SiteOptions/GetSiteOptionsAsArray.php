<?php
declare(strict_types=1);

namespace AMB\Interactor\SiteOptions;

use AMB\Factory\DbalConnection;
use AMB\Interactor\DbalConnectionTrait;
use IamPersistent\Money\Interactor\ArrayToNumber;

final class GetSiteOptionsAsArray implements DbalConnection
{
    use DbalConnectionTrait;

    public function get(): array
    {
        $data = $this->connection->fetchColumn('SELECT data FROM site_options');
        $options = json_decode($data, true);
        if (!empty($options['criticalBalanceAmount'])) {
            $options['criticalBalanceAmount'] = (new ArrayToNumber)($options['criticalBalanceAmount']);
        }
        if (!empty($options['convenienceBaseFee'])) {
            $options['convenienceBaseFee'] = (new ArrayToNumber)($options['convenienceBaseFee']);
        }
        if (!empty($options['topUpAmount'])) {
            $options['topUpAmount'] = (new ArrayToNumber)($options['topUpAmount']);
        }

        return $options;
    }
}
