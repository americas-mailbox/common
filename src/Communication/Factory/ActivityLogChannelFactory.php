<?php
declare(strict_types=1);

namespace AMB\Communication\Factory;

use AMB\Communication\Channel\ActivityLogChannel;
use AMB\Communication\Transport\ActivityLogTransport;
use Psr\Container\ContainerInterface;
use Symfony\Component\Notifier\Channel\ChannelInterface;

final class ActivityLogChannelFactory
{
    public function __construct(
        protected string $channel,
    ) {
    }

    public function __invoke(ContainerInterface $container): ChannelInterface
    {
        $transport = $container->get(ActivityLogTransport::class);

        return new ActivityLogChannel($transport);
    }
}
