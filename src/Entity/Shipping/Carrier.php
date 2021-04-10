<?php
declare(strict_types=1);

namespace AMB\Entity\Shipping;

final class Carrier
{
    /** @var bool */
    private $active;
    /** @var mixed */
    private $id;
    /** @var string */
    private $name;

    public function isActive(): bool
    {
        return $this->active;
    }

    public function setActive(bool $active): Carrier
    {
        $this->active = $active;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): Carrier
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): Carrier
    {
        $this->name = $name;

        return $this;
    }
}
