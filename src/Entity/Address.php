<?php
declare(strict_types=1);

namespace AMB\Entity;

final class Address
{
    /** @var string */
    private $addressee;
    /** @var string */
    private $address;
    /** @var string */
    private $city;
    /** @var string */
    private $country;
    /** @var int */
    private $deleted;
    /** @var int */
    private $id;
    /** @var string|null */
    private $inCareOf;
    /** @var string|null */
    private $locationName;
    /** @var \AMB\Entity\Membership */
    private $membership;
    /** @var string */
    private $plus4;
    /** @var string */
    private $postcode;
    /** @var string */
    private $state;
    /** @var string|null */
    private $suite;
    /** @var bool */
    private $verified;

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): Address
    {
        $this->address = $address;

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

    public function getDeleted(): int
    {
        return $this->deleted;
    }

    public function isDeleted(): bool
    {
        return (bool) $this->deleted;
    }

    public function setDeleted(int $value): Address
    {
        $this->deleted = $value;

        return $this;
    }

    public function getDisplayedPostCode(): string
    {
        $postcode = $this->postcode;
        if (!empty($this->plus4)) {
            $postcode .= '-'.$this->plus4;
        }

        return $postcode;
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

    public function getInCareOf(): ?string
    {
        return $this->inCareOf;
    }

    public function setInCareOf(?string $inCareOf): Address
    {
        $this->inCareOf = $inCareOf;

        return $this;
    }

    public function getLocationName(): ?string
    {
        return $this->locationName;
    }

    public function setLocationName(?string $locationName): Address
    {
        $this->locationName = $locationName;

        return $this;
    }

    public function getMembership(): Membership
    {
        return $this->membership;
    }

    public function setMembership(Membership $membership): Address
    {
        $this->membership = $membership;

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


    public function getPostcode(): string
    {
        return $this->postcode;
    }

    public function setPostcode(string $postcode): Address
    {
        $this->postcode = $postcode;

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

    public function getSuite(): ?string
    {
        return $this->suite;
    }

    public function setSuite(?string $suite): Address
    {
        $this->suite = $suite;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->verified;
    }

    public function setVerified(bool $verified): Address
    {
        $this->verified = $verified;

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
