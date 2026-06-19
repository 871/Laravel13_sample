<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class BigintCol
 implements ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_RANGE_ERROR = 1018;


    use IntTrait;

    public const STEP = 1;
    public const MIN = -100000000000;
    public const MAX = 100000000000;

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
                self::ERROR_CODE_RANGE_ERROR,
            );
        }

        $this->value = (int)$value;
    }
}
