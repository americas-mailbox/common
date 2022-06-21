<?php
declare(strict_types=1);

namespace AMB\Interactor\Log;

use AMB\Entity\Log\Activity;
use AMB\Entity\User;
use AMB\Entity\UserType;
use AMB\Interactor\RapidCityTime;
use AMB\Interactor\User\ActiveUser;

final class LogMemberLogin
{
    /** @var \AMB\Interactor\Log\InsertActivity */
    private $insertActivity;

    public function __construct(InsertActivity $insertActivity)
    {
        $this->insertActivity = $insertActivity;
    }

    public function log(string $message)
    {
        $actor = (new ActiveUser())->get();

        $target = (new ActiveUser())->get();

        $activity = (new Activity())
            ->setActor($actor)
            ->setCookie($this->getCookie('ci_session'))
            ->setDate(new RapidCityTime())
            ->setLevel('INFO')
            ->setTarget($target)
            ->setMessage($message);


        $this->insertActivity->insert($activity);

    }

    public function getCookie($index, $xss_clean = NULL)
    {
        is_bool($xss_clean) OR $xss_clean = (config_item('global_xss_filtering') === TRUE);
        $prefix = isset($_COOKIE[$index]) ? '' : config_item('cookie_prefix');
        return get_instance()->input->cookie($prefix . $index, $xss_clean);
    }
}
