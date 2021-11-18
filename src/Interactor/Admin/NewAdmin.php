<?php
declare(strict_types=1);

namespace AMB\Interactor\Admin;

use App\Authentication\Interface\NewAuthLookupInterface;

final class NewAdmin implements NewAuthLookupInterface
{
    public function __construct(
        private array $data,
    ) {
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getEmail(): string
    {
        return $this->data['email'];
    }

    public function getPassword(): string
    {
        return $this->data['password'];
    }

    public function getUsername(): string
    {
        return $this->data['username'];
    }
}
