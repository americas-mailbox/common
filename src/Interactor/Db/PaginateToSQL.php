<?php
declare(strict_types=1);

namespace AMB\Interactor\Db;

use AMB\Entity\Paginate;

final class PaginateToSQL
{
    public function __invoke(Paginate $paginate = null): string
    {
        if (!$paginate) {
            return '';
        }

        return "\nLIMIT {$paginate->getOffset()}, {$paginate->getLimit()}";
    }
}
