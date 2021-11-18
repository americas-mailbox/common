<?php
declare(strict_types=1);

namespace AMB\Interactor\Auth;

use App\Jwt\TokenData;
use App\Jwt\TokenDataGeneratorInterface;
use Zestic\Contracts\Authentication\AuthLookupInterface;

final class TokenDataGenerator implements TokenDataGeneratorInterface
{
    public function generate(AuthLookupInterface $authLookup): TokenData
    {
        $data = [
            'userId' => $authLookup->getUserId(),
        ];

        return new TokenData($data);
    }
}
