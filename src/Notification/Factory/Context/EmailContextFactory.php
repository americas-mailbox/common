<?php
declare(strict_types=1);

namespace AMB\Notification\Factory\Context;

use AMB\Entity\SiteOptions;
use Notification\Context\EmailContext;
use Notification\Factory\Context\ContextFactoryInterface;
use Notification\Recipient;
use Psr\Container\ContainerInterface;

final class EmailContextFactory implements ContextFactoryInterface
{
    public function create(ContainerInterface $container, array $data): EmailContext
    {
        $siteOptions = $container->get(SiteOptions::class);

        return (new EmailContext())
            ->setBcc($siteOptions->getBccRecipients())
            ->setFrom([$siteOptions->getFromRecipient()]);
    }
}
