<?php
declare(strict_types=1);

namespace AMB\Entity;

use Carbon\Carbon;

final class Filter
{
    public function __construct(
        private string $date,
        private ?array $paginate,
        private string $searchText,
    ) {
    }

    public function getDate(): Carbon
    {
        return new Carbon($this->date);
    }

    public function getPaginate(): ?Paginate
    {
        if (!$this->paginate) {
            return null;
        }

        return (new Paginate())
            ->setLimit($this->paginate['limit'])
            ->setOffset($this->paginate['offset']);
    }

    public function getSearchText(): string
    {
        return $this->searchText;
    }
}
