<?php
declare(strict_types=1);

namespace AMB\Interactor\Auth;

use App\Jwt\TokenData;
use App\Jwt\TokenDataGeneratorInterface;
use Zestic\Contracts\User\UserInterface;

final class TokenDataGenerator implements TokenDataGeneratorInterface
{
    public function generate(UserInterface $user): TokenData
    {
        $data = [
            'personId' => $user->getPersonId(),
        ];

        return new TokenData($data);
    }
}
