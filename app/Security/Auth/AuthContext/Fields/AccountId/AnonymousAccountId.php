<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields\AccountId;

use App\Security\Auth\AuthContext\Fields\AccountId;

class AnonymousAccountId implements AccountId
{
    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        // 処理なし
        unset($value); // 静的解析対策
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        return 0;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return '0';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
