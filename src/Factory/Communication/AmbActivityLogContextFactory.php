<?php
declare(strict_types=1);

namespace AMB\Factory\Communication;

use AMB\Communication\Context\ActivityLogContext;
use Communication\Factory\Context\ContextFactoryInterface;
use Psr\Container\ContainerInterface;

final class AmbActivityLogContextFactory implements ContextFactoryInterface
{
    public function create(ContainerInterface $container, array $config)
    {
        return new ActivityLogContext();
    }
}
