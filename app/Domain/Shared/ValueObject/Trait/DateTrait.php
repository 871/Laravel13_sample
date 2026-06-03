<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject\Trait;

use DateTime;
use DateTimeInterface;
use DomainException;

trait DateTrait
{
    /**
     * @var ?\DateTimeInterface
     */
    private readonly ?DateTimeInterface $value;

    /**
     * @param string $format
     * @return ?string
     */
    public function format(string $format = 'Y-m-d'): ?string
    {
        return $this->value?->format($format);
    }

    /**
     * @return \DateTimeInterface
     */
    public function toDate(): DateTimeInterface
    {
        return $this->value ?? throw new DomainException(
            self::class . ' value is null',
        );
    }

    /**
     * @return ?\DateTimeInterface
     */
    public function toDateOrNull(): ?DateTimeInterface
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->format() ?? '';
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
     * @param string $format
     * @return static
     */
    public static function fromString(?string $value, string $format = 'Y-m-d'): static
    {
        return new static(
            $value === null || $value === '' ? null : $value,
            $format,
        );
    }

    /**
     * @param string $value
     * @param string $format
     */
    protected static function checkFormat(string $value, string $format): bool
    {
        $dt = DateTime::createFromFormat($format, $value);

        return $dt !== false && $dt->format($format) === $value;
    }
}
