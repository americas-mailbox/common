<?php
declare(strict_types=1);

namespace AMB\Entity;

use AMB\Interactor\Admin\RoleCheck;
use App\Entity\Interfaces\PersonInterface;

final class Admin implements PersonInterface
{
    /** @var string */
    private $firstName;
    /** @var int */
    private $id;
    /** @var string */
    private $lastName;
    /** @var \AMB\Entity\AdminRole */
    private $role;
    /** @var string */
    private $username;

    public function canDo(AdminRole $role): bool
    {
        return (new RoleCheck)($this->role, $role);
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): Admin
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Admin
    {
        $this->id = $id;

        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): Admin
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getRole(): AdminRole
    {
        return $this->role;
    }

    public function setRole(AdminRole $role): Admin
    {
        $this->role = $role;

        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): Admin
    {
        $this->username = $username;

        return $this;
    }
}