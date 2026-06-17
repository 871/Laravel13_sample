<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class AccountStatusMasterCode implements Stringable
{
    use StringTrait;
    
    public const ERROR_CODE_INVALID_VALUE = 1001;

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
