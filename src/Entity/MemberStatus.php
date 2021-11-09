<?php

declare(strict_types=1);

namespace AMB\Entity;

use MyCLabs\Enum\Enum;

final class MemberStatus extends Enum
{
  // members table have column active.
  const ACTIVE = 1; // user can login.
  const CLOSED = 0; // user can not login.
  const UNVERIFIED = 2; // New member can not login.
  const UNPAID = 3; // New member got registered from frontend without making any payment.
}
