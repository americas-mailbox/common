<?php
declare(strict_types=1);

namespace AMB\Communication;

use Communication\Communication;
use Communication\Recipient;

abstract class AmbCommunication extends Communication
{
    protected ?string $activityLogFormatter = null;

    public function send()
    {
        if ($this->activityLogFormatter) {
            $this->logActivity();
        }

        parent::send();
    }

    private function logActivity(): self
    {
        $recipient = new Recipient(['log']);
        $this->addRecipient($recipient);

        $this->context->setActivityLogFormatter($this->activityLogFormatter);

        return $this;
    }

    protected function getAllowedChannels(): array
    {
        return [
            'email',
            'log',
        ];
    }
}
