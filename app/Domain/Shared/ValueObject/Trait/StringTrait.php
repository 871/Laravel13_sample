<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Trait;

trait StringTrait
{
    /**
     * @return ?string
     */
    public function toStringOrNull(): ?string
    {
        return $this->value === null || $this->value === '' ? null : $this->value;
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

    /**
     * @param ?string $value
     * @return static
     */
    public static function fromString(?string $value): static
    {
        return new static(
            $value === null || $value === '' ? null : $value,
        );
    }
}
