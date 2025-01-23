<?php
declare(strict_types=1);

namespace AMB\Interactor\Ledger;

use AMB\Interactor\Ledger\Accounting\HandlePkg;
use AMB\Interactor\Ledger\Accounting\HandlePlan;
use AMB\Interactor\Ledger\Accounting\HandlePlanExtension;
use OLPS\SimpleShop\Entity\Product;
use OLPS\SimpleShop\Interactor\PascalCase;
use Psr\Container\ContainerInterface;

final class GetSkuHandlerClass
{
    /** @var \Psr\Container\ContainerInterface */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function get(Product $sku): ?object
    {
        foreach ($sku->getCategories() as $category) {
            if ('plan' === $category->getName()) {
                return $this->container->get(HandlePlan::class);
            }
            if ('planExtension' === $category->getName()) {
                return $this->container->get(HandlePlanExtension::class);
            }
        }

        if (str_contains($sku->getName(), 'PKG')) {
            return $this->container->get(HandlePkg::class);
        }

        $pascalCase = (new PascalCase());

        $class = 'AMB\\Interactor\\Ledger\\Accounting\\Handle' . $pascalCase(strtolower($sku->getName()));

        if (!class_exists($class)) {
            return null;
        }

        if ($this->container->has($class)) {
            return $this->container->get($class);
        }

        return new $class();
    }
}
