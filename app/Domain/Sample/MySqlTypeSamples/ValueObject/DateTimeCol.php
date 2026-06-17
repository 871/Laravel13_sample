<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\DateTimeTrait;
use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Stringable;

class DateTimeCol implements Stringable
{
    use DateTimeTrait;

    public const ERROR_CODE_INVALID_FORMAT = 1001;

    public const MIN = '1970-01-01T00:00:00';
    public const MAX = '2999-12-31T23:59:59';

    /**
     * @var ?\DateTimeInterface
     */
    private readonly ?DateTimeInterface $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value, string $format = 'Y-m-d\TH:i:s')
    {
        if ($value === null) {
            $this->value = null;
            return;
        }

        if (static::checkFormat($value, $format)) {
            $resultValue = DateTimeImmutable::createFromFormat($format, $value);
            $this->value = $resultValue ?: null;
            return;
        }

        if (static::checkFormat($value . ':00', $format)) {
            $resultValue = DateTimeImmutable::createFromFormat($format, $value . ':00');
            $this->value = $resultValue ?: null;
            return;
        }

        $minDate = DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s', self::MIN);
        $maxDate = DateTimeImmutable::createFromFormat('Y-m-d\TH:i:s', self::MAX);
        $resultValue = DateTimeImmutable::createFromFormat($format, $value);
        if ($resultValue !== false && $resultValue >= $minDate && $resultValue <= $maxDate) {
            $this->value = $resultValue;
            return;
        }

        throw new DomainException(
                self::class . ' value datetime format Error'
                . '[value: ' . $value . ']'
                . '[format: ' . $format . ']',
                self::ERROR_CODE_INVALID_FORMAT,
            );
    }
}
