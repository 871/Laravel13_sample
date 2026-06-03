<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Trait;

use DomainException;

trait UuidTrait
{
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

    /**
     * @param ?string $value
     * @return static
     */
    public static function fromString(?string $value): static
    {
        if ($value === null || $value === '') {
            return new static(null);
        }

        if (!preg_match('/^[0-9a-fA-F-]{36}$/', $value)) {
            throw new DomainException(self::class . ' value uuid format Error' . '[value: ' . $value . ']');
        }

        return new static($value);
    }
}
