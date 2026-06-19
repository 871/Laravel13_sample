<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class IsActive implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_OUT_OF_TYPE = 1008;


    use IntTrait;

    public const INACTIVE = 0;
    public const ACTIVE = 1;
    public const VALUES = [self::INACTIVE, self::ACTIVE];

    private ?int $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        if ($value === null || $value === '') {
            $this->value = null;

            return;
        }

        if (!in_array((int)$value, self::VALUES, true)) {
            throw new DomainException(
                message: self::class . ' value out of type Error'
                . '[value: ' . $value . ']'
                . '[allowed: 0, 1]',
                code: self::ERROR_CODE_OUT_OF_TYPE,
            );
        }

        $this->value = (int)$value;
    }
}
