<?php
declare(strict_types=1);

namespace AMB\Interactor\Log;

use AMB\Entity\Log\Activity;
use Doctrine\DBAL\Connection;

final class InsertActivity
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function insert(Activity $activity)
    {
        $data = $this->prepareData($activity);

        $this->connection->insert('activity_logs', $data);
    }

    private function prepareData(Activity $activity): array
    {
        $this->setMetadata($activity);
        $data = [
            'actor_admin_id' => null,
            'actor_member_id' => null,
            'actor_system_id' => null,
            'browser' => $activity->getBrowser(),
            'cookie' => $activity->getCookie(),
            'date' => $activity->getDate()->toDateString(),
            'ip' => $activity->getIpAddress(),
            'level' => $activity->getLevel(),
            'message' => $activity->getMessage(),
            'office_id' => 101,
            'os' => $activity->getOs(),
            'session_id' => $activity->getSessionId(),
            'target_admin_id' => null,
            'target_member_id' => null,
            'target_system_id' => null,
            'timestamp' => $activity->getDate()->toDateTimeString(),
        ];

        $this->setActorInData($activity, $data);
        $this->setTargetInData($activity, $data);

        return $data;
    }

    private function setActorInData(Activity $activity, array &$data)
    {
        $actor = $activity->getActor();
        $type = $actor->getType()->getValue();

        $key = "actor_{$type}_id";
        $data[$key] = $actor->getId();
    }

    private function setTargetInData(Activity $activity, array &$data)
    {
        $target = $activity->getTarget();
        $type = $target->getType()->getValue();

        $key = "target_{$type}_id";
        $data[$key] = $target->getId();
    }

    private function setMetadata(Activity $activity)
    {
        if (function_exists('get_instance')) {
            $CI =& get_instance();
            $activity->setSessionId(substr($CI->session->session_id,1,6))
                ->setBrowser($CI->agent->browser() . ' ' . $CI->agent->version())
                ->setIpAddress($CI->input->ip_address())
                ->setOs($CI->agent->platform());
        } else {
            $activity->setSessionId('N/A')
                ->setBrowser(gethostname())
                ->setIpAddress(gethostbyname(gethostname()))
                ->setOs('Automatic task');
        }
    }
}
