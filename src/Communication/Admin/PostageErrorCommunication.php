<?php
declare(strict_types=1);

namespace AMB\Communication\Admin;

use AMB\Communication\AdminCommunication;
use AMB\Entity\Shipping\Shipment;
use OLPS\Money\Interactor\MoneyToString;
use Money\Money;

final class PostageErrorCommunication extends AdminCommunication
{
    public function dispatch(Shipment $shipment, Money $charge): bool
    {
        $subject = "IMPORTANT! There was a problem with a shipment charge for {$shipment->getMember()->getPMB()}";
        $this->context
            ->addEmailContext('body', $this->generateEmailBody($shipment, $charge))
            ->setSubject($subject);

        $this->send();

        return true;
    }

    protected function getAllowedChannels(): array
    {
        return [
            'email',
        ];
    }

    private function generateEmailBody(Shipment $shipment, Money $charge): string
    {
        $delivery = $shipment->getDelivery();
        $carrierName = $delivery->getCarrier()->getName();
        $charges = (new MoneyToString())($delivery->getCharges()->getTotal());
        $member = $shipment->getMember();
        $pmb = $member->getPMB();
        $url = rtrim(getenv('BASE_URL'), '/') .
            "/admin/members/ledger/{$member->getId()}";

        return <<<BODY
<p>
There was a problem getting the postage charge for PMB {$pmb}, 
{$member->getFullName()} from {$carrierName}. 
</p>
<p>
Americas Mailbox was charged {$charges}. 
</p>
<p>
Please go to the <a href="$url">ledger of PMB {$pmb}</a> and add a debit with SKU "POSTAGE_CHARGE" for the shipment.
Enter this description:
</p>
<p>
Postage charge. {$carrierName} Tracking # {$delivery->getTrackingNumber()}
</p>
BODY;
    }
}
