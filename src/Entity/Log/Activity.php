<?php
declare(strict_types=1);

namespace AMB\Entity\Log;

use AMB\Entity\User;
use Carbon\Carbon;

final class Activity
{
    /** @var \AMB\Entity\User|null */
    private $actor;
    /** @var string|null */
    private $browser;
    /** @var string|null */
    private $cookie;
    /** @var \Carbon\Carbon */
    private $date;
    /** @var int */
    private $id;
    /** @var string|null */
    private $ipAddress;
    /** @var string */
    private $level;
    /** @var string|null */
    private $message;
    /** @var string|null */
    private $os;
    /** @var string|null */
    private $pmb;
    /** @var string|null */
    private $sessionId;
    /** @var \AMB\Entity\User|null */
    private $target;
    /** @var string|null */
    private $username;

    public function getActor(): ?User
    {
        return $this->actor;
    }

    public function setActor(?User $actor): Activity
    {
        $this->actor = $actor;

        return $this;
    }

    public function getBrowser(): ?string
    {
        return $this->browser;
    }

    public function setBrowser(?string $browser): Activity
    {
        $this->browser = $browser;

        return $this;
    }

    public function getCookie(): ?string
    {
        return $this->cookie;
    }

    public function setCookie(?string $cookie): Activity
    {
        $this->cookie = $cookie;

        return $this;
    }

    public function getDate(): Carbon
    {
        return $this->date;
    }

    public function setDate(Carbon $date): Activity
    {
        $this->date = $date;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Activity
    {
        $this->id = $id;

        return $this;
    }

    public function getIpAddress(): ?string
    {
        return $this->ipAddress;
    }

    public function setIpAddress(?string $ipAddress): Activity
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    public function getLevel(): string
    {
        return $this->level;
    }

    public function setLevel(string $level): Activity
    {
        $this->level = $level;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): Activity
    {
        $this->message = $message;

        return $this;
    }

    public function getOs(): ?string
    {
        return $this->os;
    }

    public function setOs(?string $os): Activity
    {
        $this->os = $os;

        return $this;
    }

    public function getPmb(): ?string
    {
        return $this->pmb;
    }

    public function setPmb(?string $pmb): Activity
    {
        $this->pmb = $pmb;

        return $this;
    }

    public function getSessionId(): ?string
    {
        return $this->sessionId;
    }

    public function setSessionId(?string $sessionId): Activity
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    public function getTarget(): ?User
    {
        return $this->target;
    }

    public function setTarget(?User $target): Activity
    {
        $this->target = $target;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): Activity
    {
        $this->username = $username;

        return $this;
    }
}
