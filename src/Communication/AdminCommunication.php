<?php
declare(strict_types=1);

namespace AMB\Communication;

use Communication\Communication;
use Communication\Recipient;

abstract class AdminCommunication extends Communication
{
    protected function getChannelRecipients(): array
    {
        $emails = [
            'Americas.Mailbox@GMail.com',
            'joseph@blueworldweb.com',
            'shank.amb.emails@gmail.com',
        ];

        foreach ($emails as $email) {
            $recipient = (new Recipient())
                ->setEmail($email);
            $this->addRecipient($recipient);
        }

        return parent::getChannelRecipients();
    }

    protected function getTemplates(): array
    {
        return [
            'email' => [
                'html' => 'generic'
            ],
        ];
    }
}
