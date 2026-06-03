<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class AccountStatusMasterName implements Stringable
{
    use StringTrait;

    public const MAX_LENGTH = 100;

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

        if (mb_strlen($value) > self::MAX_LENGTH) {
            throw new DomainException(
                self::class . ' value too long'
                . '[maxLength: ' . (string)self::MAX_LENGTH . ']'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
            );
        }

        $this->value = $value;
    }
}
