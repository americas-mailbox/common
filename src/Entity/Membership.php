<?php
declare(strict_types=1);

namespace AMB\Entity;

final class Membership
{
    /** @var int */
    private $id;
    /** @var string */
    private $pmb;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Membership
    {
        $this->id = $id;

        return $this;
    }

    public function getPmb(): string
    {
        return $this->pmb;
    }

    public function setPmb(string $pmb): Membership
    {
        $this->pmb = $pmb;

        return $this;
    }
}
