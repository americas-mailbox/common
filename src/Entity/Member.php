<?php
declare(strict_types=1);

namespace AMB\Entity;

use Zestic\Contracts\User\UserInterface;

final class Member implements UserInterface
{
    private string $email = '';
    private string $id;
    private string $name = '';
    private string $phone = '';

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): Member
    {
        $this->email = $email;

        return $this;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Member
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Member
    {
        $this->name = $name;

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): Member
    {
        $this->phone = $phone;

        return $this;
    }
}
