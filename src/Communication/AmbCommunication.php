<?php
declare(strict_types=1);

namespace AMB\Communication;

use AMB\Notification\Context\ActivityLogContext;
use Communication\Communication;
use Symfony\Component\Notifier\Recipient\NoRecipient;

abstract class AmbCommunication extends Communication
{
    public function logActivity(string $formatter): self
    {
        $recipientChannel = (new RecipientChannels())
            ->addRecipientsToChannel('log', new NoRecipient());
        $this->addRecipientChannel($recipientChannel);

        $context = (new ActivityLogContext())
            ->setFormatter($formatter);
        $this->context->setMeta('log', $context);

        return $this;
    }
}
