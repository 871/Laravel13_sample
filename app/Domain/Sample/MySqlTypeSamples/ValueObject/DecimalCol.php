<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\FloatTrait;
use DomainException;
use Stringable;

final class DecimalCol implements Stringable
{
    use FloatTrait;

    public const STEP = 0.01;
    public const SCALE = 2;
    public const MIN = 0.01;
    public const MAX = 99999.99;

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
            throw new DomainException("Invalid decimal format: {$value}");
        }

        if (
            // Memo: STEPの判定は省略
            (float)$value < self::MIN || (float)$value > self::MAX
        ) {
            throw new DomainException(
                self::class . ' value range Error'
                . '[value: ' . $value . ']'
                . '[MIN: ' . (string)self::MIN . ']'
                . '[MAX: ' . (string)self::MAX . ']'
                . '[STEP: ' . (string)self::STEP . ']',
            );
        }

        $this->value = sprintf('%.' . (string)self::SCALE . 'f', $value);
    }
}
