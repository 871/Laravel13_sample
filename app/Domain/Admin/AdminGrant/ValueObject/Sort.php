<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class Sort implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_INTEGER_FORMAT = 1002;


    use IntTrait;

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

        if (!preg_match('/^-?\d{1,10}$/', $value)) {
            throw new DomainException(
                message: self::class . ' value integer format Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                code: self::ERROR_CODE_INTEGER_FORMAT,
            );
        }

        $this->value = (int)$value;
    }
}
