<?php
declare(strict_types=1);

namespace App\Domain\User\UserAccounts\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class Password implements Stringable
{
    use StringTrait;

    public const MAX_LENGTH = 255;

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        if ($value !== null && mb_strlen($value) > self::MAX_LENGTH) {
            throw new DomainException(
                self::class . ' value too long'
                . '[maxLength: ' . (string)self::MAX_LENGTH . ']',
            );
        }
    }
}
