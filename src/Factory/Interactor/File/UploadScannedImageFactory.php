<?php
declare(strict_types=1);

namespace AMB\Factory\Interactor\File;

use AMB\Interactor\File\UploadScannedImage;
use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class UploadScannedImageFactory
{
    public function __invoke(ContainerInterface $container): UploadScannedImage
    {
        $connection = $container->get(Connection::class);
        $files = $container->get('imageFiles');

        return new UploadScannedImage($connection, $files);
    }
}
