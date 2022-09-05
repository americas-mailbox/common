<?php
declare(strict_types=1);

namespace AMB\Interactor\Image\Db;

use AMB\Entity\Image;

final class DehydrateImage
{
    public function __invoke(Image $image): array
    {
        return [
            'created_at' => $image->getCreatedAt()?->toDateTimeString(),
            'filepath'   => $image->getFilePath(),
            'id'         => $image->getId(),
            'ratio'      => $image->getRatio(),
            'updated_at' => $image->getUpdatedAt()?->toDateTimeString(),
        ];
    }
}


