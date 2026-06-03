<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class Name implements Stringable
{
    use StringTrait;

    public const MAX_LENGTH = 100;

    public const ERROR_CODE_LENGTH = 1001;

    private ?string $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        if ($value === null || $value === '') {
            $this->value = null;

            return;
        }

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new DomainException(
                message: self::class . ' value too long'
                . '[maxLength: ' . (string)self::MAX_LENGTH . ']'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                code: self::ERROR_CODE_LENGTH,
            );
        }

        $this->value = $value;
    }
}
