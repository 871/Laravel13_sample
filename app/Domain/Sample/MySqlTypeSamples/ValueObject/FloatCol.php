<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\FloatTrait;
use DomainException;
use Stringable;

final class FloatCol implements Stringable
{
    use FloatTrait;

    public const STEP = 0.00001;
    public const SCALE = 5;
    public const MIN = -99999.99999;
    public const MAX = 99999.99999;

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
            throw new DomainException("Invalid float format: {$value}");
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
            );
        }

        $this->value = sprintf('%.' . (string)self::SCALE . 'f', $value);
    }
}
