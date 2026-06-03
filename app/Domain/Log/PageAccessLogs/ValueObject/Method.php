<?php
declare(strict_types=1);

namespace App\Domain\Log\PageAccessLogs\ValueObject;

use DomainException;
use Stringable;

class Method implements Stringable
{
    public const MAX_LENGTH = 10;

    /**
     * @param string $value
     */
    public function __construct(
        private readonly string $value,
    ) {
        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new DomainException(
                self::class . ' value length Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
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
