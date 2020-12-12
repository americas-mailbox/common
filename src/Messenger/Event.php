<?php
declare(strict_types=1);

namespace AMB\Messenger;

use App\Message;
use IamPersistent\SwiftMailer\Context\PartyContext;

abstract class Event extends Message
{
    use MemberMessageTrait;

    /** @var \IamPersistent\SwiftMailer\Context\PartyContext|null */
    protected $sendTo;

    public function getSendTo(): ?PartyContext
    {
        if (null === $this->sendTo) {
            return null;
        }

        if (!$this->sendTo instanceof PartyContext) {
            $this->sendTo = new PartyContext($this->sendTo['email'], $this->sendTo['name']);
        }

        return $this->sendTo;
    }
}
