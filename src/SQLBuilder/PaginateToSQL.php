<?php
declare(strict_types=1);

namespace AMB\SQLBuilder;

use App\Entity\Paginate;

final class PaginateToSQL
{
    public function __invoke(Paginate $paginate = null): string
    {
        if (!$paginate) {
            return '';
        }

        return "\nLIMIT {$paginate->getStartIndex()}, {$paginate->getBatchSize()}";
    }
}
