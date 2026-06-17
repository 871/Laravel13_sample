<?php
declare(strict_types=1);

namespace App\Domain\User\UserAccounts\ValueObject;

use App\Domain\Shared\ValueObject\Trait\DateTimeTrait;
use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Stringable;

class PasswordChangedAt implements Stringable
{
    use DateTimeTrait;

    const ERROR_CODE_INVALID_FORMAT = 1001;

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

        if (!static::checkFormat($value, $format)) {
            throw new DomainException(
                self::class . ' value datetime format Error'
                . '[value: ' . $value . ']'
                . '[format: ' . $format . ']',
                self::ERROR_CODE_INVALID_FORMAT
            );
        }

        $resultValue = DateTimeImmutable::createFromFormat($format, $value);
        $this->value = $resultValue ?: null;
    }
}
