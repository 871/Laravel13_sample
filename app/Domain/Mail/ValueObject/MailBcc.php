<?php
declare(strict_types=1);

namespace App\Domain\Mail\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class MailBcc implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_LENGTH = 1005;
    public const ERROR_CODE_VALUE_PROCESSING = 1013;
    public const ERROR_CODE_EMAIL_FORMAT = 1001;


    use StringTrait;

    public const MAX_LENGTH = 16383;

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

        $splitLines = preg_split('/\R/u', $value);
        if ($splitLines === false) {
            throw new DomainException(self::class . ' value parsing error', self::ERROR_CODE_VALUE_PROCESSING);
        }
        $emails = array_values(
            array_filter(
                array_map(
                    static fn(string $line): string => trim($line),
                    $splitLines,
                ),
                static fn(string $line): bool => $line !== '',
            ),
        );
        if ($emails === []) {
            $this->value = null;

            return;
        }
        foreach ($emails as $email) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                throw new DomainException(
                    self::class . ' value email format Error'
                    . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                    self::ERROR_CODE_EMAIL_FORMAT,
                );
            }
        }

        $this->value = implode("\n", $emails);
    }

    /**
     * @return array<string>
     */
    public function toArray(): array
    {
        return $this->value === null ? [] : explode("\n", $this->value);
    }
}
