<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use ReflectionProperty;

final class ClearId
{
    public function __invoke(object $object, string $idProperty = 'id'): void
    {
        $objectProperty = new ReflectionProperty($object, $idProperty);
        $objectProperty->setAccessible(true);
        $objectProperty->setValue($object, null);
        $objectProperty->setAccessible(false);
    }
}
