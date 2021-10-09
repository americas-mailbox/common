<?php
declare(strict_types=1);

namespace AMB\Factory\Communication;

use AMB\Entity\SiteOptions;
use Communication\Context\EmailContext;
use Communication\Factory\Context\ContextFactoryInterface;
use Psr\Container\ContainerInterface;

final class AmbEmailContextFactory implements ContextFactoryInterface
{
    public function create(ContainerInterface $container, array $config): EmailContext
    {
        $messageFactory = $container->get($config['messageFactory']);
        $siteOptions = $container->get(SiteOptions::class);

        return (new EmailContext($messageFactory))
            ->setBcc($siteOptions->getBccRecipients())
            ->setFrom([$siteOptions->getFromRecipient()]);
    }
}
