<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Trait;

use DomainException;

trait IntTrait
{
    /**
     * @return int
     */
    public function toInt(): int
    {
        return (int)$this->value;
    }

    /**
     * @return ?int
     */
    public function toIntOrNull(): ?int
    {
        return $this->value === null ? null : (int)$this->value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return (string)$this->value;
    }

    /**
     * @return ?string
     */
    public function toStringOrNull(): ?string
    {
        return $this->value === null ? null : (string)$this->value;
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

        if (preg_match('/^-?\d+$/', $value)) {
            return new static($value);
        }

        throw new DomainException(
            self::class . ' value not int Error'
                . '[value: ' . $value . ']',
        );
    }
}
