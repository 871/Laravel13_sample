<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields;

use Stringable;

class IsEmailVerified implements Stringable
{
    /**
     * @param bool $value
     */
    public function __construct(
        private readonly bool $value,
    ) {
    }

    /**
     * @return bool
     */
    public function toBool(): bool
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value ? '1' : '0';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
