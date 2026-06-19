<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\ValueObject;

use App\Domain\Shared\ValueObject\Trait\UuidTrait;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class GrantAccountPermissionId implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_INVALID_VALUE = 1014;


    use UuidTrait;

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

        if (!preg_match('/^[0-9a-fA-F-]{36}$/', $value)) {
            throw new DomainException(
                self::class . ' value uuid format Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_INVALID_VALUE,
            );
        }

        $this->value = $value;
    }
}
