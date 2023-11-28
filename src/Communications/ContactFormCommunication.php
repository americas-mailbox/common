<?php
declare(strict_types=1);

namespace AMB\Communications;

use Communication\Communication;
use Communication\Context\EmailContext;
use Communication\Recipient;

final class ContactFormCommunication extends Communication
{
    public function dispatch(array $message)
    {
        $replyTo = (new Recipient())
            ->setEmail($message['email'])
            ->setName($message['name']);
        $recipient = (new Recipient())
            ->setEmail('Americas.Mailbox@gmail.com');
        $this->addRecipient($recipient);

        $this->context
            ->addToContext('contactEmail', $message['email'])
            ->addToContext('message', $message['message'])
            ->addToContext('name', $message['name'])
            ->addToContext('phone', $message['phone'])
            ->addToContext('pmb', $message['pmb'])
            ->addToContext('subject', $message['subject'])
            ->setReplyTo([$replyTo])
            ->setSubject($message['subject']);
        $this->send();

        return true;
    }

    protected function getAllowedChannels(): array
    {
        return [
            'email',
        ];
    }

    protected function getTemplates(): array
    {
        return [
            'email' => [
                'html' => 'staff.contact-form',
            ],
        ];
    }
}
