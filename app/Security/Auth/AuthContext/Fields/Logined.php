<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields;

use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Stringable;

class Logined implements Stringable
{
    /**
     * @var ?\DateTimeInterface
     */
    private readonly ?DateTimeInterface $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value, string $format = 'Y-m-d\TH:i:s')
    {
        if ($value === null) {
            $this->value = null;

            return;
        }

        if (!static::checkFormat($value, $format)) {
            throw new DomainException(
                self::class . ' value datetime format Error'
                . '[value: ' . $value . ']'
                . '[format: ' . $format . ']',
            );
        }

        $resultValue = DateTimeImmutable::createFromFormat($format, $value);
        $this->value = $resultValue ?: null;
    }

    /**
     * @return ?\DateTimeInterface
     */
    public function toDateTimeOrNull(): ?DateTimeInterface
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value?->format('Y-m-d\TH:i:s') ?? '';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
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
