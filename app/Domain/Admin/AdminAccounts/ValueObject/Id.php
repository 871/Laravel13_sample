<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class Id implements Stringable
{
    use IntTrait;

    public const ERROR_CODE_INVALID_FORMAT = 1001;
    public const ERROR_CODE_RANGE_OVER = 1002;

    public const MIN = 900000;
    public const MAX = 999999;

    /**
     * @param ?string $value
     */
    private ?string $value;

    /**
     * @param ?string $value
     */
    public function __construct(
        ?string $value,
    ) {
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

        if ((int)$value < self::MIN || (int)$value > self::MAX) {
            throw new DomainException(
                self::class . ' value range Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_RANGE_OVER,
            );
        }

        $this->value = $value;
    }
}
