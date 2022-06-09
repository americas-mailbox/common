<?php
declare(strict_types=1);

namespace AMB\SQLBuilder;

use App\Entity\Paginate;
use Doctrine\DBAL\Connection;

abstract class AbstractFetchData
{
    protected string $prefix;
    protected mixed $conditions;
    protected array $selectedProperties;
    protected string $tableName;

    public function __construct(
        private Connection $connection,
        protected SQLBuilderInterface $sqlBuilder,
        private TransformerInterface $transformer,
    ) {
    }

    public function setSelectedProperties(array $properties = []): static
    {
        $this->sqlBuilder->setSelectedProperties($properties);
        $this->selectedProperties = $properties;

        return $this;
    }

    public function fetchList(Paginate $paginate = null, bool $transform = true): array
    {
        $sql = $this->sql($paginate);
        $rawData = $this->connection->fetchAllAssociative($sql);
        $data = [];
        foreach ($rawData as $datum) {
            $data[] = $this->transformer->transform($datum, $this->prefix);
        }

        return $data;
    }

    public function getTotal(): int
    {
        $sql = "SELECT COUNT(*) FROM {$this->tableName} as {$this->prefix} {$this->where()}";

        return (int) $this->connection->fetchOne($sql);
    }

    public function setConditions($conditions): static
    {
        $this->conditions = $conditions;

        return $this;
    }

    public function setDataPrefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function setTableName(string $name): static
    {
        $this->tableName = $name;

        return $this;
    }

    protected function sql(Paginate $paginate = null): string
    {
        $sql = $this->sqlBuilder->sql();
        $sql .= $this->where();
        $sql .= (new PaginateToSQL)($paginate);

        return $sql;
    }

    protected function where(): string
    {
        return 'WHERE ' . implode(' AND ', $this->conditions);
    }
}
