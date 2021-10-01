<?php
declare(strict_types=1);

namespace AMB\Interactor\Account;

use AMB\Entity\Member;
use AMB\Interactor\RapidCityTime;
use Doctrine\DBAL\Connection;
use IamPersistent\SimpleShop\Entity\CreditCard;
use IamPersistent\SimpleShop\Interactor\DBal\HydrateCreditCard;

final class GetDefaultCardForPayment
{
    public function __construct(
        private Connection $connection,
        private UpdateAccount $updateAccount,
    ) {  }

    public function disableAutoPayments(Member $member)
    {
        $account = $member->getAccount();
        // send notification
        $account
            ->setAutoRenew(false)
            ->setAutoTopUp(false);
        $this->updateAccount->update($account);
    }

    public function for(Member $member): ?CreditCard
    {
        $account = $member->getAccount();
        $defaultCard = $account->getDefaultCard();
        if ($this->cardIsValid($defaultCard)) {
            return $defaultCard;
        }
        $cards = $this->getCreditCards($member);
        if (count($cards) !== 1) {
            $this->disableAutoPayments($member);

            return null;
        }

        $defaultCard = $cards[0];
        $account->setDefaultCard($defaultCard);
        $this->updateAccount->update($account);

        return $defaultCard;
    }

    private function cardIsValid(?CreditCard $creditCard): bool
    {
        if (!$creditCard) {
            return false;
        }
        if (!$creditCard->isActive()) {
            return false;
        }
        if ((RapidCityTime::firstOfTheMonth())->gt($creditCard->getExpirationDate())){
            return false;
        }

        return true;
    }

    private function getCreditCards(Member $member): array
    {
        $statement = $this->connection->executeQuery("SELECT * FROM credit_cards WHERE owner_id ={$member->getId()}");
        $cardData = $statement->fetchAllAssociative();

        $cards = [];
        foreach ($cardData as $cardDatum) {
            if ($card = $this->hydratedValidCard($cardDatum)) {
                $cards[] = $card;
            }
        }

        return $cards;
    }

    private function hydratedValidCard(array $data): ?CreditCard
    {
        $card = (new HydrateCreditCard())($data);
        if (!$this->cardIsValid($card)) {
            return null;
        }

        return $card;
    }
}
