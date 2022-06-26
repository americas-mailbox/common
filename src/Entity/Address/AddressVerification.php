<?php
declare(strict_types=1);

namespace AMB\Entity\Address;

final class AddressVerification
{
    /** @var array */
    private $addressData;
    /** @var string|int */
    private $addressId;
    /** @var bool */
    private $error;
    /** @var string */
    private $errorMessage;
    /** @var bool */
    private $match;
    /** @var array */
    private $rawData;
    /** @var string */
    private $warningMessage;

    public function getAddressData(): array
    {
        return $this->addressData;
    }

    public function setAddressData(array $addressData): AddressVerification
    {
        $this->addressData = $addressData;

        return $this;
    }

    public function getAddressId(): int|string|null
    {
        return $this->addressId;
    }

    public function setAddressId(int|string|null $addressId): AddressVerification
    {
        $this->addressId = $addressId;

        return $this;
    }

    public function isError(): bool
    {
        return $this->error;
    }

    public function setError(bool $error): AddressVerification
    {
        $this->error = $error;

        return $this;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(string $errorMessage): AddressVerification
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    public function isMatch(): bool
    {
        return $this->match;
    }

    public function setMatch(bool $match): AddressVerification
    {
        $this->match = $match;

        return $this;
    }

    public function getRawData(): array
    {
        return $this->rawData;
    }

    public function setRawData(array $rawData): AddressVerification
    {
        $this->rawData = $rawData;

        return $this;
    }

    public function getWarningMessage(): string
    {
        return $this->warningMessage;
    }

    public function setWarningMessage(string $warningMessage): AddressVerification
    {
        $this->warningMessage = $warningMessage;

        return $this;
    }
}
