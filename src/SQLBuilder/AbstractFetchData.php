<?php
declare(strict_types=1);

namespace AMB\SQLBuilder;

use App\Entity\Paginate;
use App\Response\PaginationTransformer;
use Doctrine\DBAL\Connection;
use Zestic\GraphQL\GraphQLMessage;

abstract class AbstractFetchData
{
    protected string $prefix;
    protected mixed $conditions;
    protected array $selectedProperties;
    protected string $tableName;

    public function __construct(
        protected Connection $connection,
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
        $sql = $this->listSql($paginate);
        $rawData = $this->connection->fetchAllAssociative($sql);
        if (!$transform) {
            return $rawData;
        }
        $data = [];
        foreach ($rawData as $datum) {
            $data[] = $this->transformer->transform($datum, $this->prefix);
        }

        return $data;
    }

    public function fetchOne(bool $transform = true): array|null
    {
        $sql = $this->sql();
        $rawData = $this->connection->fetchAssociative($sql);
        if (!$transform) {
            return $rawData;
        }

        return $this->transformer->transform($rawData, $this->prefix);
    }

    public function getTotal(): int
    {
        $sql = "SELECT COUNT(*)\n";
        $sql .= $this->sqlBuilder->from();
        $sql .= $this->sqlBuilder->joins();
        $sql .= $this->where();

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

    public function setListResponse(GraphQLMessage $message, string $propertyName)
    {
        $paginate = $message->getPaginate();

        $list = $this->fetchList($paginate);
        $total = $this->getTotal();
        $response = [
            '_pagination' => (new PaginationTransformer)($paginate, $total),
            $propertyName   => $list,
        ];
        $message->setResponse($response);
    }

    public function setTableName(string $name): static
    {
        $this->tableName = $name;

        return $this;
    }

    protected function listSql(Paginate $paginate = null): string
    {
        $sql = $this->sqlBuilder->sql();
        $sql .= $this->where();
        $sql .= $this->orderBy();
        $sql .= (new PaginateToSQL)($paginate);

        return $sql;
    }

    protected function sql(): string
    {
        $sql = $this->sqlBuilder->sql();
        $sql .= $this->where();

        return $sql;
    }

    protected function orderBy(): string
    {
        return '';
    }

    protected function where(): string
    {
        return 'WHERE ' . implode(' AND ', $this->conditions) . "\n";
    }
}
