<?php
declare(strict_types=1);

namespace App\Domain\Mail\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class MailReturnPath implements Stringable
{
    use StringTrait;

    public const MAX_LENGTH = 255;
    public const ERROR_CODE_LENGTH = 1001;
    public const ERROR_CODE_EMAIL_FORMAT = 1002;

    /**
     * @param ?string $value
     */
    private readonly ?string $value;

    /**
     * @param ?string $value
     */
    public function __construct(
        ?string $value,
    ) {
        if ($value === null || $value === '') {
            $this->value = null;

            return;
        }
        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new DomainException(
                self::class . ' value length Error'
                . '[max length: ' . (string)self::MAX_LENGTH . ']'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_LENGTH,
            );
        }

        $trimmed = trim($value);
        if (filter_var($trimmed, FILTER_VALIDATE_EMAIL) === false) {
            throw new DomainException(
                self::class . ' value email format Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_EMAIL_FORMAT,
            );
        }

        $this->value = $trimmed;
    }
}
