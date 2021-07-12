<?php
declare(strict_types=1);

namespace AMB\Entity;

final class Location
{
    /** @var int */
    private $id;
    /** @var string */
    private $label;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Location
    {
        $this->id = $id;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): Location
    {
        $this->label = $label;

        return $this;
    }
}
