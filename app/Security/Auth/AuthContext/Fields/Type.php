<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields;

use DomainException;
use Stringable;

class Type implements Stringable
{
    public const TYPE_ANONYMOUS = 'anonymous';
    public const TYPE_CUSTMER = 'custmer';
    public const TYPE_USER = 'user';
    public const TYPE_ADMIN = 'admin';

    /**
     * @param string $value
     */
    public function __construct(
        private readonly string $value,
    ) {
        if (
            in_array($this->value, [
                self::TYPE_ANONYMOUS,
                self::TYPE_CUSTMER,
                self::TYPE_USER,
                self::TYPE_ADMIN,
            ], true) === false
        ) {
            throw new DomainException(
                self::class . ' Generate Error'
                . '[type: ' . $this->value . ']',
            );
        }
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
