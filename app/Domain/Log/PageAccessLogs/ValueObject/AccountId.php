<?php
declare(strict_types=1);

namespace App\Domain\Log\PageAccessLogs\ValueObject;

use DomainException;
use Stringable;

class AccountId implements Stringable
{
    public const ERROR_CODE_NOT_EMPTY = 1001;
    public const ERROR_CODE_INVALID_FORMAT = 1002;
    public const ERROR_CODE_RANGE_UNDER = 1003;

    public const MIN = 1;

    /**
     * @var int
     */
    private int $value;

    /**
     * @param string $value
     */
    public function __construct(string $value)
    {
        if ($value === '') {
            throw new DomainException(
                self::class . ' value format Error'
                . '[value: ' . $value . ']',
                self::ERROR_CODE_NOT_EMPTY,
            );
        }

        if (!preg_match('/^\d+$/', $value)) {
            throw new DomainException(
                self::class . ' value format Error'
                . '[value: ' . $value . ']',
                self::ERROR_CODE_INVALID_FORMAT,
            );
        }

        if ((int)$value < self::MIN) {
            throw new DomainException(
                self::class . ' value range Error'
                . '[value: ' . $value . ']',
                self::ERROR_CODE_RANGE_UNDER,
            );
        }

        $this->value = (int)$value;
    }

    /**
     * @return int
     */
    public function toInt(): int
    {
        return (int)$this->value;
    }

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
     * @param string $value
     * @return self
     */
    public static function fromString(string $value): self
    {
        return new self($value);
    }
}
