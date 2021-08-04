<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Location;

final class HydrateLocation
{
    public function hydrate(array $locationData): Location
    {
        return (new Location())
            ->setId($locationData['location_id'])
            ->setLabel($locationData['location_label']);
    }
}
