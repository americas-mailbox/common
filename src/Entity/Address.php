<?php
declare(strict_types=1);

namespace AMB\Entity;

final class Address
{
    /** @var string */
    private $addressee;
    /** @var string */
    private $city;
    /** @var string */
    private $country;
    /** @var int */
    private $id;
    /** @var string */
    private $plus4;
    /** @var string */
    private $postCode;
    /** @var string */
    private $state;
    /** @var string */
    private $street1;
    /** @var string|null */
    private $street2;
    /** @var string|null */
    private $street3;
    /** @var User */
    private $user;
    /** @var int */
    private $deleted;

    public function getDeleted(): int
    {
        return $this->deleted;
    }

    public function setDeleted(int $value): Address
    {
        $this->deleted = $value;

        return $this;
    }

    public function getAddressee(): string
    {
        return $this->addressee;
    }

    public function setAddressee(string $addressee): Address
    {
        $this->addressee = $addressee;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): Address
    {
        $this->city = $city;

        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): Address
    {
        $this->country = $country;

        return $this;
    }

    public function getDisplayedPostCode(): string
    {
        $postCode = $this->postCode;
        if (!empty($this->plus4)) {
            $postCode .= '-'.$this->plus4;
        }

        return $postCode;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Address
    {
        $this->id = $id;

        return $this;
    }

    public function getPlus4(): ?string
    {
        return $this->plus4;
    }

    public function setPlus4(?string $plus4): Address
    {
        $this->plus4 = $plus4;

        return $this;
    }

    public function getPostCode(): string
    {
        return $this->postCode;
    }

    public function setPostCode(string $postCode): Address
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getState(): string
    {
        return $this->state;
    }

    public function setState(string $state): Address
    {
        $this->state = $state;

        return $this;
    }

    public function getStreet1(): string
    {
        return $this->street1;
    }

    public function setStreet1(string $street1): Address
    {
        $this->street1 = $street1;

        return $this;
    }

    public function getStreet2(): ?string
    {
        return $this->street2;
    }

    public function setStreet2(?string $street2): Address
    {
        $this->street2 = $street2;

        return $this;
    }

    public function getStreet3(): ?string
    {
        return $this->street3;
    }

    public function setStreet3(?string $street3): Address
    {
        $this->street3 = $street3;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): Address
    {
        $this->user = $user;

        return $this;
    }
}
