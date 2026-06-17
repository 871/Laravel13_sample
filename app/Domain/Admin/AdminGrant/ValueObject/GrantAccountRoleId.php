<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class GrantAccountRoleId implements Stringable
{
    use StringTrait;

    public const ERROR_CODE_INVALID_FORMAT = 1001;

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
                self::class . ' value UUID format Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_INVALID_FORMAT,
            );
        }

        $this->value = $value;
    }
}
