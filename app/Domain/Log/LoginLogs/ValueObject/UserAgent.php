<?php
declare(strict_types=1);

namespace App\Domain\Log\LoginLogs\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class UserAgent implements Stringable
{
    use StringTrait;

    public const ERROR_CODE_MAX_LENGTH_EXCEEDED = 1001;

    public const MAX_LENGTH = 65535;

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        if ($value !== null && mb_strlen($value) > self::MAX_LENGTH) {
            throw new DomainException(
                self::class . ' value length Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_MAX_LENGTH_EXCEEDED,
            );
        }
    }
}
