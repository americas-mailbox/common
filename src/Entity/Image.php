<?php
declare(strict_types=1);

namespace AMB\Entity;

final class Image
{
    private string $filePath;
    private mixed $id;

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

    public function getUrl(): string
    {
        return 'http://img.americasmailbox.com/' . $this->filePath;
    }
}
