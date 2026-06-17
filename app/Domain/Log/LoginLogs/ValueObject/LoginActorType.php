<?php
declare(strict_types=1);

namespace App\Domain\Log\LoginLogs\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class LoginActorType implements Stringable
{
    use StringTrait;

    public const ERROR_CODE_INVALID_VALUE = 1001;

    public const ADMIN = 'ADMIN';
    public const USER = 'USER';
    public const VALUES = [self::ADMIN, self::USER];

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        if ($value !== null && !in_array($value, self::VALUES, true)) {
            throw new DomainException(
                self::class . ' value out of range Error'
                . '[value: ' . $value . ']'
                . '[allowed: ' . implode(', ', self::VALUES) . ']',
                self::ERROR_CODE_INVALID_VALUE,
            );
        }
    }
}
