<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\TimeTrait;
use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Stringable;

class TimeCol implements Stringable
{
    use TimeTrait;

    public const MIN = '00:00:00';
    public const MAX = '23:59:59';

    /**
     * @var ?\DateTimeInterface
     */
    private readonly ?DateTimeInterface $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value, string $format = 'H:i:s')
    {
        if ($value === null) {
            $this->value = null;

            return;
        }

        if (!static::checkFormat($value, $format)) {
            throw new DomainException(
                self::class . ' value time format Error'
                . '[value: ' . $value . ']'
                . '[format: ' . $format . ']',
            );
        }

        $minDate = DateTimeImmutable::createFromFormat('H:i:s', self::MIN);
        $maxDate = DateTimeImmutable::createFromFormat('H:i:s', self::MAX);
        $resultValue = DateTimeImmutable::createFromFormat($format, $value);
        if ($resultValue === false || $resultValue < $minDate || $resultValue > $maxDate) {
            throw new DomainException(
                self::class . ' value time range Error'
                . '[value: ' . $value . ']'
                . '[min: ' . self::MIN . ']'
                . '[max: ' . self::MAX . ']',
            );
        }
        $this->value = $resultValue;
    }
}
