<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields;

use DomainException;

class AccountEmail
{
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

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new DomainException(
                self::class . ' value email format Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
            );
        }

        $this->value = $value;
    }

    /**
     * @return ?string
     */
    public function toStringOrNull(): ?string
    {
        return $this->value;
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
