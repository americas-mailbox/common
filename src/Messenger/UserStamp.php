<?php
declare(strict_types=1);

namespace AMB\Messenger;

use AMB\Entity\User;
use Symfony\Component\Messenger\Stamp\StampInterface;

final class UserStamp implements StampInterface
{
    /** @var User */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
