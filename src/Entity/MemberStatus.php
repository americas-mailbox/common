<?php

declare(strict_types=1);

namespace AMB\Entity;

enum MemberStatus: string
{
    case ACTIVE = 'ACTIVE';
    case CLOSED = 'CLOSED'; // user cannot log in
    case SUSPENDED = 'SUSPENDED';
    case UNVERIFIED = 'UNVERIFIED';
}
