<?php
declare(strict_types=1);

namespace AMB\Interactor\Log;

use AMB\Factory\DbalConnection;
use AMB\Interactor\DbalConnectionTrait;

final class GetLogData implements DbalConnection
{
    use DbalConnectionTrait;

    public function get(array $params): array
    {
        $sql = <<<SQL
SELECT 
`timestamp`,
    concat(adminActor.first_name, ' ', adminActor.last_name) AS adminActor,
    concat(memberActor.first_name, ' ', memberActor.last_name, ' (#',memberActor.PMB, ')') AS memberActor,
    concat(systemActor.first_name, ' ', systemActor.last_name) AS systemActor,
concat(l.os,': ',l.browser) as browser,
ip,       
session_id AS sessionId,
    concat(adminTarget.first_name, ' ', adminTarget.last_name) AS adminTarget,
    concat(memberTarget.first_name, ' ', memberTarget.last_name) AS memberTarget,
    concat(systemTarget.first_name, ' ', systemTarget.last_name) AS systemTarget,
message
FROM activity_logs AS l
LEFT JOIN administrators as adminActor ON l.actor_admin_id = adminActor.id 
LEFT JOIN administrators as systemActor ON l.actor_system_id = systemActor.id 
LEFT JOIN members as memberActor ON l.actor_member_id = memberActor.member_id 
LEFT JOIN administrators as adminTarget ON l.target_admin_id = adminTarget.id 
LEFT JOIN administrators as systemTarget ON l.target_system_id = systemTarget.id 
LEFT JOIN members as memberTarget ON l.target_member_id = memberTarget.member_id
SQL;
        $sql .= $this->tableParamsSQL($params);

        if (isset($params['page']) && $params['page'] > 1) {
            $offset = $params['rowsPerPage'] * ($params['page'] - 1);
        } else {
            $offset = 0;
        }

        $sql .= " ORDER BY timestamp DESC";
        if((int)$params['rowsPerPage'] !== -1){
            $sql .= " LIMIT {$offset}, {$params['rowsPerPage']}";
        }
        $data = $this->connection->fetchAllAssociative($sql);

        return $this->formatForTable($data, $params);
    }

    protected function formatForTable(array $data, array $params)
    {
        $totalItems = $this->getItemTotal($params);
        $items = [];

        foreach ($data as $datum) {
            $items[] = $this->formatItem($datum);
        }

        return [
            'items' => $items,
            'totalItems' => $totalItems,
        ];
    }

    protected function formatItem(array $data): array
    {
        $actor = current(array_filter([
            $data['adminActor'],
            $data['memberActor'],
            $data['systemActor'],
        ]));
        $target = current(array_filter([
            $data['adminTarget'],
            $data['memberTarget'],
            $data['systemTarget'],
        ]));

        return [
            'timestamp' => $data['timestamp'],
            'actor' => $actor !== false ? $actor : '',
            'browser' => $data['browser'],
            'ip' => $data['ip'],
            'sessionId' => $data['sessionId'],
            'target' => $target !== false ? $target : '',
            'message' => $data['message'],
        ];
    }

    protected function tableParamsSQL(array $params): string
    {
        $parts = [];
        if ($params['date']) {
            $parts[] = "date = '{$params['date']}' AND date > '2020-06-16'";
        }
        if ($params['dataFor'] !== 'all') {
            $parts[] = "target_member_id = {$params['dataFor']} ";
        }
        if ($params['searchByPMB']) {
            $parts[] = "memberTarget.pmb like '{$params['searchByPMB']}%'";
        }
        if ($params['search']) {
            $parts[] = "l.message LIKE '%{$params['search']}%'";
        }

        return ' WHERE ' . implode(' AND ', $parts);
    }

    protected function getItemTotal(array $params): int
    {
        $sql = 'SELECT count(l.id) FROM activity_logs as l';
        if (isset($params['searchByPMB'])) {
            $sql .= ' LEFT JOIN members as memberTarget on l.target_member_id = memberTarget.member_id';
        }
        $sql .= $this->tableParamsSQL($params);

        return (int)$this->connection->fetchOne($sql);
    }
}
