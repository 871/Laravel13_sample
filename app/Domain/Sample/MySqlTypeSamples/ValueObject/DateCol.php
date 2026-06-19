<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\DateTrait;
use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class DateCol implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_INVALID_FORMAT = 1003;
    public const ERROR_CODE_INVALID_RANGE = 1004;


    use DateTrait;

    public const MIN = '1970-01-01';
    public const MAX = '2999-12-31';

    /**
     * @param ?string $value
     */
    public function __construct(?string $value, string $format = 'Y-m-d')
    {
        if ($value === null) {
            $this->value = null;

            return;
        }

        if (!static::checkFormat($value, $format)) {
            throw new DomainException(
                self::class . ' value date format Error'
                . '[value: ' . $value . ']'
                . '[format: ' . $format . ']',
                self::ERROR_CODE_INVALID_FORMAT,
            );
        }

        $minDate = DateTimeImmutable::createFromFormat('Y-m-d', self::MIN);
        $maxDate = DateTimeImmutable::createFromFormat('Y-m-d', self::MAX);
        $resultValue = DateTimeImmutable::createFromFormat($format, $value);
        if ($resultValue === false || $resultValue < $minDate || $resultValue > $maxDate) {
            throw new DomainException(
                self::class . ' value date range Error'
                . '[value: ' . $value . ']'
                . '[min: ' . self::MIN . ']'
                . '[max: ' . self::MAX . ']',
                self::ERROR_CODE_INVALID_RANGE,
            );
        }

        $this->value = $resultValue;
    }
}
