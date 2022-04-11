<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

final class ExtractGatheredData
{
    public function __invoke(array &$data, ?string $prefix, array $keyChanges = []): array
    {
        $prefix = $prefix ? rtrim($prefix, '!') . '!' : '';
        $extractPropertyName = function (string $property) use ($keyChanges): string {
            $parts = explode('!', $property);
            $propertyName = array_pop($parts);

            return $keyChanges[$propertyName] ?? $propertyName;
        };

        $extracted = [];
        foreach ($data as $property => $value) {
            if (str_starts_with($property, $prefix)) {
                $propertyName = $extractPropertyName($property);
                $extracted[$propertyName] = $value;
                unset($data[$property]);
            }
        }

        return $extracted;
    }
}
