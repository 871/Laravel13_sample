<?php
declare(strict_types=1);

namespace App\Domain\Mail\ValueObject;

use App\Domain\Shared\ValueObject\Trait\DateTimeTrait;
use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class SendScheduledAt implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_INVALID_FORMAT = 1003;


    use DateTimeTrait;

    /**
     * @var ?\DateTimeInterface
     */
    private readonly ?DateTimeInterface $value;

    /**
     * @param ?string $value
     * @param string $format
     */
    public function __construct(?string $value, string $format = 'Y-m-d\TH:i:s')
    {
        if ($value === null) {
            $this->value = null;

            return;
        }

        if (!static::checkFormat($value, $format)) {
            throw new DomainException(
                self::class . ' value datetime format Error'
                . '[value: ' . $value . ']'
                . '[format: ' . $format . ']',
                self::ERROR_CODE_INVALID_FORMAT,
            );
        }

        $resultValue = DateTimeImmutable::createFromFormat($format, $value);
        $this->value = $resultValue ?: null;
    }
}
