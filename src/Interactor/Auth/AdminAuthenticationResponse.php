<?php
declare(strict_types=1);

namespace AMB\Interactor\Auth;

use Zestic\Contracts\Authentication\AuthenticationResponseInterface;
use Zestic\Contracts\User\UserInterface;

final class AdminAuthenticationResponse implements AuthenticationResponseInterface
{
    public function response(UserInterface $person, string $jwt, int $expiresAt): array
    {
        return [
            'expiresAt' => $expiresAt,
            'jwt'       => $jwt,
            'admin'     => $person,
            'success'   => true,
        ];
    }
}
