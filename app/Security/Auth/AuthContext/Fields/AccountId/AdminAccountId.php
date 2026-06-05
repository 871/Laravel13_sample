<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields\AccountId;

use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Security\Auth\AuthContext\Fields\AccountId;
use DomainException;

class AdminAccountId implements AccountId
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
        $this->value = (new Vo\Id($value))->toIntOrNUll() ?? throw new DomainException(
            self::class . ' Generate Error'
            . '[value: ' . (string)$value . ']',
        );
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
