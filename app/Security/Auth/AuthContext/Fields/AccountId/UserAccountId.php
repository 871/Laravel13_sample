<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields\AccountId;

use App\Security\Auth\AuthContext\Fields\AccountId;
use DomainException;

class UserAccountId implements AccountId
{
    /**
     * @var int
     */
    private int $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if (!preg_match('/^[1-9]\d*$/', $value)) {
            throw new DomainException(
                self::class . ' Generate Error'
                . '[value: ' . $value . ']',
            );
        }

        $this->value = (int)$value;
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return (string)$this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
