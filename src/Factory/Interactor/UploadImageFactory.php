<?php
declare(strict_types=1);

namespace AMB\Factory\Interactor;

use AMB\Interactor\Image\FindImageById;
use AMB\Interactor\Image\UploadImage;
use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class UploadImageFactory
{
    public function __invoke(ContainerInterface $container): UploadImage
    {
        $connection = $container->get(Connection::class);
        $findImageById = $container->get(FindImageById::class);
        $files = $container->get('imageFiles');

        return new UploadImage($connection, $findImageById, $files);
    }
}
