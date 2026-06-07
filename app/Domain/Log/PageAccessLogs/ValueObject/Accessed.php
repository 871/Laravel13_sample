<?php
declare(strict_types=1);

namespace App\Domain\Log\PageAccessLogs\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Stringable;

class Accessed implements Stringable
{
    /**
     * @var \DateTimeInterface
     */
    private readonly DateTimeInterface $value;

    /**
     * @param string $value
     * @param string $format
     */
    public function __construct(string $value, string $format = 'Y-m-d\\TH:i:s.u')
    {
        // Try provided format first, then fall back to common variants without failing immediately
        $formatsToTry = [$format, 'Y-m-d\\TH:i:s.u', 'Y-m-d\\TH:i:s'];
        $dt = null;
        foreach ($formatsToTry as $f) {
            $dt = DateTimeImmutable::createFromFormat($f, $value) ?: null;
            if ($dt !== null) {
                break;
            }
        }

        if ($dt === null) {
            throw new DomainException(
                self::class . ' value datetime format Error'
                . '[value: ' . $value . ']',
            );
        }

        $this->value = $dt;
    }

    /**
     * @param string $format
     * @return string
     */
    public function format(string $format = 'Y-m-d\TH:i:s'): string
    {
        return $this->value->format($format);
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->format();
    }

    /**
     * @param string $value
     * @param string $format
     * @return self
     */
    public static function fromString(string $value, string $format = 'Y-m-d\TH:i:s'): self
    {
        return new self($value, $format);
    }
}
