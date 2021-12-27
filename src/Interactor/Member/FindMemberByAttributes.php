<?php

declare(strict_types=1);

namespace AMB\Interactor\Member;

use AMB\Entity\Member;
use AMB\Interactor\Db\HydrateMember;
use Doctrine\DBAL\Connection;

final class FindMemberByAttributes
{
    public function __construct(
        private Connection $connection,
        private HydrateMember $hydrateMember
    ) {
    }

    public function find(array $attributes, string $operator = 'OR'): array | null
    {
        $memberData = $this->gather($attributes, $operator);
        if (empty($memberData)) {
            return null;
        }

        return $memberData;
    }

    private function gather(array $attributes, string $operator)
    {
        $sql = $this->sql($attributes, $operator);
        $statement = $this->connection->executeQuery($sql['statement'], $sql['params']);
        $memberData = $statement->fetchAssociative();
        if (empty($memberData)) {
            return null;
        }

        return $memberData;
    }

    private function sql(array $attributes, string $operator): array
    {
        $whereCondition = implode(
            $operator === 'OR' ? ' OR ' : ' AND ',
            array_map(
                function ($e) {
                    return $e . '= ?';
                },
                array_keys($attributes)
            )
        );
        $columnValues = array_values($attributes);
        return [
            'statement' => "SELECT * FROM members WHERE $whereCondition",
            'params' => $columnValues
        ];
    }
}
