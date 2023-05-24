<?php
declare(strict_types=1);

namespace AMB\Interactor\Image\Db;

use AMB\Interactor\Db\HydrateImage;

final class HydrateImages
{
    public function __construct (
        private HydrateImage $hydrateImage,
    ) {}

    public function hydrate($data): array
    {
        if (is_string($data)) {
            $data = json_decode($data, true);
        }
        $images = [];
        foreach ($data as $datum) {
            $images[] = $this->hydrateImage->hydrate($datum);
        }

        return $images;
    }
}
