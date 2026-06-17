<?php
declare(strict_types=1);

namespace App\Domain\Mail\ValueObject;

use DomainException;
use Stringable;

class SendStatus implements Stringable
{
    public const ERROR_CODE_INVALID_VALUE = 1001;

    public const WAITING = 'WAITING';
    public const SENT = 'SENT';
    public const FAILED = 'FAILED';
    public const RECEIVED = 'RECEIVED';
    public const BOUNCED = 'BOUNCED';
    public const VALUES = [
        self::WAITING,
        self::SENT,
        self::FAILED,
        self::RECEIVED,
        self::BOUNCED,
    ];

    /**
     * @param string $value
     */
    public function __construct(
        private readonly string $value,
    ) {
        if (!in_array($value, self::VALUES, true)) {
            throw new DomainException(
                self::class . ' value out of range Error'
                . '[value: ' . $value . ']'
                . '[allowed: ' . implode(', ', self::VALUES) . ']',
                self::ERROR_CODE_INVALID_VALUE,
            );
        }
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
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
