<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Shipping\Carrier;

final class HydrateCarrier
{
    public function hydrate($data): Carrier
    {
        return (new Carrier())
            ->setActive((bool) $data['active'])
            ->setId($data['id'])
            ->setName($data['name']);
    }
}
