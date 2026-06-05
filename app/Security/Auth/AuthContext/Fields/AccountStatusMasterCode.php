<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields;

use DomainException;

class AccountStatusMasterCode
{
    public const PENDING = 'PENDING';
    public const ACTIVE = 'ACTIVE';
    public const SUSPENDED = 'SUSPENDED';
    public const LOCKED = 'LOCKED';
    public const DELETED = 'DELETED';

    /**
     * @var ?string
     */
    private ?string $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        if ($value === null || $value === '') {
            $this->value = null;

            return;
        }

        if (
            in_array($value, [
            self::PENDING,
            self::ACTIVE,
            self::SUSPENDED,
            self::LOCKED,
            self::DELETED,
            ], true) === false
        ) {
            throw new DomainException(
                self::class . ' value type Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
            );
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value ?? '';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
