<?php
declare(strict_types=1);

namespace AMB\Entity\Shipping;

final class PackageSize
{
    /** @var string */
    private $height;
    /** @var string */
    private $length;
    /** @var string */
    private $unit;
    /** @var string */
    private $width;

    public function getHeight(): string
    {
        return $this->height;
    }

    public function setHeight(string $height): PackageSize
    {
        $this->height = $height;

        return $this;
    }

    public function getLength(): string
    {
        return $this->length;
    }

    public function setLength(string $length): PackageSize
    {
        $this->length = $length;

        return $this;
    }

    public function getUnit(): string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): PackageSize
    {
        $this->unit = $unit;

        return $this;
    }

    public function getWidth(): string
    {
        return $this->width;
    }

    public function setWidth(string $width): PackageSize
    {
        $this->width = $width;

        return $this;
    }
}
