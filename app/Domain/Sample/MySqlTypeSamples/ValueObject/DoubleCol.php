<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\FloatTrait;
use DomainException;
use Stringable;

final class DoubleCol implements Stringable
{
    use FloatTrait;

    public const ERROR_CODE_INVALID_FORMAT = 1001;
    public const ERROR_CODE_INVALID_RANGE = 1002;

    public const STEP = 0.0005;
    public const SCALE = 4;
    public const MIN = 0.0000;
    public const MAX = 99999.9999;

    /**
     * @var string
     */
    private readonly ?string $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        if ($value === null) {
            $this->value = null;

            return;
        }

        if (!preg_match('/^-?\d+(\.\d{0, ' . (string)self::SCALE . '})?$/', $value)) {
            throw new DomainException(
                "Invalid double format: {$value}",
                self::ERROR_CODE_INVALID_FORMAT,
            );
        }

        if (
            (float)$value < self::MIN || (float)$value > self::MAX
            || (float)$value % self::STEP !== 0
        ) {
            throw new DomainException(
                self::class . ' value range Error'
                . '[value: ' . $value . ']'
                . '[MIN: ' . (string)self::MIN . ']'
                . '[MAX: ' . (string)self::MAX . ']'
                . '[STEP: ' . (string)self::STEP . ']',
                self::ERROR_CODE_INVALID_RANGE,
            );
        }

        $this->value = sprintf('%.' . (string)self::SCALE . 'f', $value);
    }
}
