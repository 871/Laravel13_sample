<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class AccountStatusMasterCode implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_INVALID_VALUE = 1014;


    use StringTrait;

    public const PENDING = 'PENDING';
    public const ACTIVE = 'ACTIVE';
    public const SUSPENDED = 'SUSPENDED';
    public const LOCKED = 'LOCKED';
    public const DELETED = 'DELETED';

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

        if (
            in_array($value, [
            self::PENDING,
            self::ACTIVE,
            self::SUSPENDED,
            self::LOCKED,
            self::DELETED,
            ], true) === false
        ) {
            throw new DomainException(
                self::class . ' value type Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_INVALID_VALUE,
            );
        }

        $this->value = $value;
    }
}
