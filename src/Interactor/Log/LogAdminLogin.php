<?php
declare(strict_types=1);

namespace AMB\Interactor\Log;

use AMB\Entity\Log\Activity;
use AMB\Entity\User;
use AMB\Entity\UserType;
use AMB\Interactor\RapidCityTime;

final class LogAdminLogin
{
    /** @var \AMB\Interactor\Log\InsertActivity */
    private $insertActivity;

    public function __construct(InsertActivity $insertActivity)
    {
        $this->insertActivity = $insertActivity;
    }

    public function log($admin, $action)
    {
        $actor = (new User())
            ->setId((int)$admin->id)
            ->setType(UserType::ADMIN());

        $target = (new User())
            ->setId((int)$admin->id)
            ->setType(UserType::ADMIN());

        $activity = (new Activity())
            ->setActor($actor)
            ->setCookie($this->getCookie('ci_session'))
            ->setDate(new RapidCityTime())
            ->setLevel('INFO')
            ->setTarget($target);

        if ($action === 'in') {
            $activity->setMessage("User ({$admin->role}) logged in successfully.");
        } elseif ($action === 'out') {
            $activity->setMessage("User ({$admin->role}) logged out.");
        }

        $this->insertActivity->insert($activity);

//        $this->load->library('user_agent');
//        $this->load->helper('cookie');
//
//        $addData = array();
//
//        $addData['ip'] = $this->input->ip_address();
//        $addData['browser'] = $this->agent->browser() . ' ' . $this->agent->version();
//        $addData['os'] = $this->agent->platform();
//        $addData['session_id'] = $this->session->session_id;
    }

    public function getCookie($index, $xss_clean = NULL)
    {
        is_bool($xss_clean) OR $xss_clean = (config_item('global_xss_filtering') === TRUE);
        $prefix = isset($_COOKIE[$index]) ? '' : config_item('cookie_prefix');
        return get_instance()->input->cookie($prefix . $index, $xss_clean);
    }
}
