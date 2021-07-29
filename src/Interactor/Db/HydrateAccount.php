<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Account;
use AMB\Interactor\RapidCityTime;
use IamPersistent\Ledger\Interactor\DBal\FindLedgerById;
use IamPersistent\Ledger\Interactor\DBal\JsonToMoney;
use IamPersistent\SimpleShop\Interactor\DBal\FindCardById;

final class HydrateAccount
{
    public function __construct(
        private FindCardById $findCardById,
        private FindLedgerById $findLedgerById,
        private HydrateAccountNotification $hydrateNotifications,
    )  {
    }

    public function hydrate(array $data): Account
    {
        $criticalBalance = (new JsonToMoney())($data['critical_balance']);
        $minimumAllowedBalance = (new JsonToMoney())($data['minimum_allowed_balance']);
        $topUpAmount = (new JsonToMoney())($data['top_up_amount']);
        $ledger = $this->findLedgerById->find((int)$data['ledger_id']);
        $notifications = $this->hydrateNotifications->hydrate(json_decode($data['notifications'], true));
        $account = (new Account())
            ->setAutoRenew((bool) $data['auto_renew'])
            ->setAutoTopUp((bool) $data['auto_top_up'])
            ->setCriticalBalance($criticalBalance)
            ->setCustomAutoTopUp((bool) $data['custom_auto_top_up'])
            ->setCustomCriticalBalance((bool) $data['custom_critical_balance'])
            ->setCustomMinimumAllowedBalance((bool) $data['custom_minimum_allowed_balance'])
            ->setId((int) $data['id'])
            ->setLedger($ledger)
            ->setMinimumAllowedBalance($minimumAllowedBalance)
            ->setNotifications($notifications)
            ->setOfficeClosedDeliveryPreference($data['office_closed_delivery'])
            ->setTopUpAmount($topUpAmount);
        if (!empty($data['default_card_id'])) {
            if ($card = $this->findCardById->find($data['default_card_id'])) {
                $account->setDefaultCard($card);
            }
        }
        if (!empty($data['renewDate'])) {
            $account->setRenewalDate(new RapidCityTime($data['renewDate']));
        }
        if (!empty($data['startDate'])) {
            $account->setStartDate(new RapidCityTime($data['startDate']));
        }

        return $account;
    }
}
