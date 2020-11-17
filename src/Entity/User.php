<?php
declare(strict_types=1);

namespace AMB\Entity;

final class User
{
    /** @var int */
    private $id;
    /** @var string */
    private $pmb;
    /** @var UserType */
    private $type;
    /** @var string */
    private $username;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id = null): User
    {
        $this->id = $id;

        return $this;
    }

    public function getPmb(): ?string
    {
        return $this->pmb;
    }

    public function setPmb(?string $pmb): User
    {
        $this->pmb = $pmb;

        return $this;
    }

    public function getType(): UserType
    {
        return $this->type;
    }

    public function setType(UserType $type): User
    {
        $this->type = $type;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(?string $username): User
    {
        $this->username = $username;

        return $this;
    }
}
