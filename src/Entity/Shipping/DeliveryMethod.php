<?php
declare(strict_types=1);

namespace AMB\Entity\Shipping;

final class DeliveryMethod
{
    /** @var \AMB\Entity\Shipping\Carrier|null */
    private $carrier;
    /** @var string */
    private $group;
    /** @var int */
    private $id;
    /** @var string */
    private $label;
    private ?string $shortLabel = null;

    public function getCarrier(): ?Carrier
    {
        return $this->carrier;
    }

    public function setCarrier(Carrier $carrier): DeliveryMethod
    {
        $this->carrier = $carrier;

        return $this;
    }

    public function getGroup(): ?string
    {
        return $this->group;
    }

    public function setGroup(?string $group): DeliveryMethod
    {
        $this->group = $group;

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): DeliveryMethod
    {
        $this->id = $id;

        return $this;
    }

    public function getDisplayedLabel(): string
    {
        if ($this->carrier) {
            return $this->carrier->getName() . ' - ' . $this->label;
        }

        return $this->label;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): DeliveryMethod
    {
        $this->label = $label;

        return $this;
    }

    public function getShortLabel(): ?string
    {
        return $this->shortLabel;
    }

    public function setShortLabel(?string $shortLabel): DeliveryMethod
    {
        $this->shortLabel = $shortLabel;

        return $this;
    }
}
