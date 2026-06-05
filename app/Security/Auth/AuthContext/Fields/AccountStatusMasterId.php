<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields;

use DomainException;

class AccountStatusMasterId
{
    /**
     * @var ?int
     */
    private ?int $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        if ($value === null || $value === '') {
            $this->value = null;

            return;
        }

        if (!preg_match('/^\d+$/', $value)) {
            throw new DomainException(
                self::class . ' value integer format Error'
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
        return $this->value ?? 0;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return (string)($this->value ?? 0);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
