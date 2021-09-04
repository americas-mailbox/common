<?php
declare(strict_types=1);

namespace AMB\Interactor\Auth;

use Zestic\Contracts\Authentication\AuthenticationResponseInterface;
use Zestic\Contracts\Person\PersonInterface;

final class AdminAuthenticationResponse implements AuthenticationResponseInterface
{
    public function response(PersonInterface $person, string $jwt, int $expiresAt): array
    {
        return [
            'expiresAt' => $expiresAt,
            'jwt'       => $jwt,
            'admin'     => $person,
            'success'   => true,
        ];
    }
}
