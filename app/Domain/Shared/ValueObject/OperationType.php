<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class OperationType implements Stringable
{
    use StringTrait;
    // TODO: 参照: app/Domain/User/UserAccounts/ValueObject/Name.php:25
    public const ERROR_CODE_INVALID_VALUE = 1001;

    public const INSERT = 'INSERT';
    public const UPDATE = 'UPDATE';
    public const DELETE = 'DELETE';

    public const ALLOWED_VALUES = [
        self::INSERT,
        self::UPDATE,
        self::DELETE,
    ];

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        if ($value !== null && !in_array($value, self::ALLOWED_VALUES, true)) {
            throw new DomainException(
                self::class . ' value not allowed'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...'
            ) . ']'
                . '[allowed: ' . implode(', ', self::ALLOWED_VALUES) . ']',
            self::ERROR_CODE_INVALID_VALUE,
            );
        }
    }
}
