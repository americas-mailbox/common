<?php
declare(strict_types=1);

namespace AMB\Messenger;

use AMB\Entity\User;
use Symfony\Component\Messenger\Stamp\StampInterface;

final readonly class UserStamp implements StampInterface
{
    public function __construct(private User $user)
    {
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
