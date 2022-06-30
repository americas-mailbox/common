<?php
declare(strict_types=1);

namespace AMB\Entity\Address;

final class AddressVerification
{
    /** @var array */
    private $addressData;
    private string|int|null $addressId;
    private bool $error = true;
    private string|null $errorMessage;
    /** @var bool */
    private $match;
    /** @var array */
    private $rawData;
    private string|null $warningMessage;

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

    public function getErrorMessage(): string|null
    {
        return $this->errorMessage;
    }

    public function setErrorMessage(string|null $errorMessage): AddressVerification
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

    public function getWarningMessage(): string|null
    {
        return $this->warningMessage;
    }

    public function setWarningMessage(string|null $warningMessage): AddressVerification
    {
        $this->warningMessage = $warningMessage;

        return $this;
    }
}
