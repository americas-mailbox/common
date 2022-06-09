<?php
declare(strict_types=1);

namespace AMB\SQLBuilder;

final class ExtractAndTransformGatheredData
{
    public function __invoke(array &$data, ?string $prefix, array $keyChanges = [], array $transformations = []): array
    {
        $prefix = $prefix ? rtrim($prefix, '!') . '!' : '';
        $extractPropertyName = function (string $property) use ($keyChanges): string {
            $parts = explode('!', $property);
            $propertyName = array_pop($parts);

            return $keyChanges[$propertyName] ?? $propertyName;
        };

        $transformValue = function (string $property, $value) use ($transformations) {
            return isset($transformations[$property]) ? $transformations[$property]->transform($value) : $value;
        };

        $extracted = [];
        foreach ($data as $property => $value) {
            if (str_starts_with($property, $prefix)) {
                $propertyName = $extractPropertyName($property);
                $extracted[$propertyName] = $transformValue($propertyName, $value);
                unset($data[$property]);
            }
        }

        return $extracted;
    }
}
