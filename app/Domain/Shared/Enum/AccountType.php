<?php
declare(strict_types=1);

namespace App\Domain\Shared\Enum;

enum AccountType: string
{
    case ADMIN = 'ADMIN';
    case USER = 'USER';
}
