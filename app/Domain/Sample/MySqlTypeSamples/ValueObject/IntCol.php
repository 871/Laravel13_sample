<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class IntCol implements Stringable
{
    use IntTrait;

    public const ERROR_CODE_INVALID_FORMAT = 1001;
    public const ERROR_CODE_INVALID_RANGE = 1002;

    public const STEP = 1;
    public const MIN = 1;
    public const MAX = 100;

    private ?int $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        if ($value === null || $value === '') {
            $this->value = null;

            return;
        }

        // Memo: STEPの判定は省略
        if (!preg_match('/^-?\d+$/', $value)) {
            throw new DomainException(
                self::class . ' value format Error'
                . '[value: ' . $value . ']'
                . '[MIN: ' . (string)self::MIN . ']'
                . '[MAX: ' . (string)self::MAX . ']'
                . '[STEP: ' . (string)self::STEP . ']',
                self::ERROR_CODE_INVALID_FORMAT,
            );
        }

        if ((int)$value < self::MIN || (int)$value > self::MAX) {
            throw new DomainException(
                self::class . ' value range Error'
                . '[value: ' . $value . ']'
                . '[MIN: ' . (string)self::MIN . ']'
                . '[MAX: ' . (string)self::MAX . ']'
                . '[STEP: ' . (string)self::STEP . ']',
                self::ERROR_CODE_INVALID_RANGE,
            );
        }

        $this->value = (int)$value;
    }
}
