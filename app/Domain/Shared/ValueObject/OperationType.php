<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class OperationType implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_INVALID_VALUE = 1014;


    use StringTrait;

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
