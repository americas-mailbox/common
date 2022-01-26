<?php
declare(strict_types=1);

namespace AMB\Interactor\Image\Db;

final class DehydrateImages
{
    public function __invoke(array $images): array
    {
        $dehydrated = [];
        foreach ($images as $image) {
            $dehydrated[] = (new DehydrateImage)($image);
        }

        return $dehydrated;
    }
}


