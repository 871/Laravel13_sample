<?php
declare(strict_types=1);

namespace App\Domain\Log\LoginLogs\ValueObject;

use App\Domain\Shared\ValueObject\Trait\DateTimeTrait;
use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Stringable;

class LoggedInAt implements Stringable
{
    use DateTimeTrait;

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

        throw new DomainException(
            self::class . ' value datetime format Error'
            . '[value: ' . $value . ']'
            . '[format: ' . $format . ']',
        );
    }
}
