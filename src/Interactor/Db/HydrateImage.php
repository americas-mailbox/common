<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Image;

final class HydrateImage
{
    public function hydrate(array $data): Image
    {
        $toDate = new SQLToRapidCityTime();

        return (new Image())
            ->setCreatedAt($toDate($data['created_at']))
            ->setFilePath($data['filepath'])
            ->setId($data['id'])
            ->setUpdatedAt($toDate($data['updated_at']));

    }
}
