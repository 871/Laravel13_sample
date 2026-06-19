<?php
declare(strict_types=1);

namespace App\Domain\User\UserAccounts\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class IsEmailVerified implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_OUT_OF_RANGE = 1015;


    use IntTrait;

    public const VALUES = [0, 1];

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

        if (!in_array((int)$value, self::VALUES, true) || !preg_match('/^\d+$/', $value)) {
            throw new DomainException(
                self::class . ' value out of range Error'
                . '[value: ' . $value . ']'
                . '[allowed: 0, 1]',
                self::ERROR_CODE_OUT_OF_RANGE,
            );
        }

        $this->value = (int)$value;
    }
}
