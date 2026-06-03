<?php
declare(strict_types=1);

namespace App\Domain\Mail\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class Body implements Stringable
{
    use StringTrait;

    public const MAX_LENGTH = 4194303;
    public const ERROR_CODE_LENGTH = 1001;

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        if ($value !== null && mb_strlen($value) > self::MAX_LENGTH) {
            throw new DomainException(
                self::class . ' value length Error'
                . '[max length: ' . (string)self::MAX_LENGTH . ']'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_LENGTH,
            );
        }
    }
}
