<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields;

class AccountName
{
    /**
     * @param string $value
     */
    public function __construct(
        private string $value,
    ) {
        // 処理なし
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
