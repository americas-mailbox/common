<?php
declare(strict_types=1);

namespace AMB\Factory;

use AMB\Entity\SiteOptions;
use AMB\Interactor\SiteOptions\HydrateSiteOptions;
use Doctrine\DBAL\Connection;
use Psr\Container\ContainerInterface;

final class SiteOptionsFactory
{
    public function __invoke(ContainerInterface $container): SiteOptions
    {
        /** @var \Doctrine\DBAL\Connection */
        $connection = $container->get(Connection::class);
        $data = $connection->fetchOne('SELECT data FROM site_options');
        $options = json_decode($data, true);

        return (new HydrateSiteOptions)($options);
    }
}
