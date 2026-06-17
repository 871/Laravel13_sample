<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class GrantRoleId implements Stringable
{
    use IntTrait;

    public const ERROR_CODE_INVALID_FORMAT = 1001;
    public const ERROR_CODE_RANGE_OVER = 1002;

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

        if (!preg_match('/^\d+$/', $value)) {
            throw new DomainException(
                self::class . ' value integer format Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_INVALID_FORMAT,
            );
        }

        if ((int)$value <= 0) {
            throw new DomainException(
                self::class . ' value must be positive'
                . '[value: ' . $value . ']',
                self::ERROR_CODE_RANGE_OVER,
            );
        }

        $this->value = (int)$value;
    }
}
