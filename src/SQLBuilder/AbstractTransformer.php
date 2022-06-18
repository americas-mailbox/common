<?php
declare(strict_types=1);

namespace AMB\SQLBuilder;

abstract class AbstractTransformer implements TransformerInterface
{
    public function transform(array $data, string $prefix): array
    {
        return (new ExtractAndTransformGatheredData)(
            $data,
            $prefix,
            [],
            $this->transformations(),
        );
    }

    abstract protected function transformations(): array;
}
