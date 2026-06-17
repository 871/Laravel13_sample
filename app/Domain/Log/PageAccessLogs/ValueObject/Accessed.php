<?php
declare(strict_types=1);

namespace App\Domain\Log\PageAccessLogs\ValueObject;

use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Stringable;

class Accessed implements Stringable
{
    // TODO: 参照: app/Domain/User/UserAccounts/ValueObject/Name.php:25
    public const ERROR_CODE_INVALID_VALUE = 1001;

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
        $dt = DateTimeImmutable::createFromFormat($format, $value) ?: null;
        if ($dt === null) {
            throw new DomainException(
                self::class . ' value datetime format Error'
                . '[value: ' . $value . ']',
                self::ERROR_CODE_INVALID_VALUE,
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
