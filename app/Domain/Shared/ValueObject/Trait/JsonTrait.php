<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Trait;

trait JsonTrait
{
    /**
     * @var ?array<mixed>
     */
    private readonly ?array $value;

    /**
     * @return string
     */
    public function toString(): string
    {
        if ($this->value === null) {
            return '';
        }

        return json_encode($this->value) ? : '';
    }

    /**
     * @return ?string
     */
    public function toStringOrNull(): ?string
    {
        if ($this->value === null) {
            return null;
        }

        return json_encode($this->value) ? : null;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @return array<mixed>
     */
    public function jsonSerialize(): array
    {
        if ($this->value === null || $this->value === []) {
            return [];
        }

        return (array)$this->value;
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
