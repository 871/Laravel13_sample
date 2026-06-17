<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class ModifiedIp implements Stringable
{
    use StringTrait;
    // TODO: 参照: app/Domain/User/UserAccounts/ValueObject/Name.php:25
    public const ERROR_CODE_INVALID_VALUE = 1001;

    public const MAX_LENGTH = 45;

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        if ($value !== null) {
            if (mb_strlen($value) > self::MAX_LENGTH) {
                throw new DomainException(
                self::class . ' value too long'
                . '[maxLength: ' . (string)self::MAX_LENGTH . ']'
                    . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_INVALID_VALUE,
                );
            }
        }
    }
}
