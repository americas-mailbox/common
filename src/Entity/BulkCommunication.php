<?php
declare(strict_types=1);

namespace AMB\Entity;

use AMB\Interactor\RapidCityTime;

final class BulkCommunication
{
    /** @var bool */
    private $completed;
    private ?string $csvFilename = null;
    /** @var string */
    private $emailBody;
    private ?int $id = null;
    /** @var \AMB\Interactor\RapidCityTime */
    private $scheduledFor;
    /** @var array */
    private $sendOptions;
    /** @var string */
    private $smsBody;
    /** @var string */
    private $subject;
    /** @var string */
    private $title;

    public function isCompleted(): bool
    {
        return $this->completed;
    }

    public function setCompleted(bool $completed): BulkCommunication
    {
        $this->completed = $completed;

        return $this;
    }

    public function getCsvFilename(): ?string
    {
        return $this->csvFilename;
    }

    public function setCsvFilename(?string $csvFilename): BulkCommunication
    {
        $this->csvFilename = $csvFilename;

        return $this;
    }

    public function getEmailBody(): string
    {
        return $this->emailBody;
    }

    public function setEmailBody(string $emailBody): BulkCommunication
    {
        $this->emailBody = $emailBody;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): BulkCommunication
    {
        $this->id = $id;

        return $this;
    }

    public function getScheduledFor(): RapidCityTime
    {
        return $this->scheduledFor;
    }

    public function setScheduledFor(RapidCityTime $scheduledFor): BulkCommunication
    {
        $this->scheduledFor = $scheduledFor;

        return $this;
    }

    public function getSendOptions(): array
    {
        return $this->sendOptions;
    }

    public function setSendOptions(array $sendOptions): BulkCommunication
    {
        $this->sendOptions = $sendOptions;

        return $this;
    }

    public function getSmsBody(): string
    {
        return $this->smsBody;
    }

    public function setSmsBody(string $smsBody): BulkCommunication
    {
        $this->smsBody = $smsBody;

        return $this;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): BulkCommunication
    {
        $this->subject = $subject;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): BulkCommunication
    {
        $this->title = $title;

        return $this;
    }
}
