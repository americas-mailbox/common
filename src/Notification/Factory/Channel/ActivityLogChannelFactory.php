<?php
declare(strict_types=1);

namespace AMB\Notification\Factory\Channel;

use AMB\Notification\Channel\ActivityLogChannel;
use AMB\Notification\Transport\ActivityLogTransport;
use Psr\Container\ContainerInterface;
use Symfony\Component\Notifier\Channel\ChannelInterface;

final class ActivityLogChannelFactory
{
    private $config;

    public function __construct(
        $config
    ) {
        $this->config = $config;
    }

    public function __invoke(ContainerInterface $container): ChannelInterface
    {
        $transport = $container->get(ActivityLogTransport::class);

        return new ActivityLogChannel($transport);
    }
}
