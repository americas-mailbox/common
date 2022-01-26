<?php
declare(strict_types=1);

namespace AMB\Entity;

use AMB\Interactor\RapidCityTime;

final class Image
{
    private RapidCityTime $createdAt;
    private string $filePath;
    private mixed $id;
    private ?RapidCityTime $updatedAt;

    public function getCreatedAt(): RapidCityTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(RapidCityTime $createdAt): Image
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getFilePath(): string
    {
        return $this->filePath;
    }

    public function setFilePath(string $filePath): Image
    {
        $this->filePath = $filePath;

        return $this;
    }

    public function getId(): mixed
    {
        return $this->id;
    }

    public function setId(mixed $id): Image
    {
        $this->id = $id;

        return $this;
    }

    public function getUpdatedAt(): ?RapidCityTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?RapidCityTime $updatedAt): Image
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getUrl(): string
    {
        return 'http://img.americasmailbox.com/' . $this->filePath;
    }
}
