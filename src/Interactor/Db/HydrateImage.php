<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Image;

final class HydrateImage
{
    public function hydrate(array $data): Image
    {
        return (new Image())
            ->setFilePath($data['filepath'])
            ->setId($data['id']);
    }
}
