<?php
declare(strict_types=1);

namespace App\Domain\Log\LoginLogs\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class LoginResult implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_INVALID_VALUE = 1014;


    use StringTrait;

    public const SUCCESS = 'SUCCESS';
    public const FAILURE = 'FAILURE';
    public const VALUES = [self::SUCCESS, self::FAILURE];

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
