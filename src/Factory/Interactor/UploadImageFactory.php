<?php
declare(strict_types=1);

namespace AMB\Factory\Interactor;

use AMB\Interactor\Image\UploadImage;
use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class UploadImageFactory
{
    public function __invoke(ContainerInterface $container): UploadImage
    {
        $connection = $container->get(Connection::class);
        $files = $container->get('imageFiles');

        return new UploadImage($connection, $files);
    }
}
