<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class IntCol implements Stringable
{
    use IntTrait;

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

        if (
            // Memo: STEPの判定は省略
            !preg_match('/^-?\d+$/', $value)
            || ((int)$value < self::MIN || (int)$value > self::MAX)
        ) {
            throw new DomainException(
                self::class . ' value range Error'
                . '[value: ' . $value . ']'
                . '[MIN: ' . (string)self::MIN . ']'
                . '[MAX: ' . (string)self::MAX . ']'
                . '[STEP: ' . (string)self::STEP . ']',
            );
        }

        $this->value = (int)$value;
    }
}
