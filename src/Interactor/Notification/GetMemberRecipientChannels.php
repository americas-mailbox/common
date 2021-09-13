<?php
declare(strict_types=1);

namespace AMB\Interactor\Notification;

use AMB\Entity\Member;
use Notification\Recipient;
use Notification\RecipientChannels;

final class GetMemberRecipientChannels
{
    public function getRecipientChannels(Member $member): RecipientChannels
    {
        if (!$member->getEmail()) {
            return new RecipientChannels();
        }

        $email = "{$member->getFullName()} <{$member->getEmail()}>";
        $recipient = (new Recipient())
            ->setEmail($email);

        return (new RecipientChannels())
            ->addRecipientsToChannel('email', $recipient);
    }
}
