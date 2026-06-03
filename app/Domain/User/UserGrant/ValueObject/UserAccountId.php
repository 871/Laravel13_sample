<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class UserAccountId implements Stringable
{
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

        if (!preg_match('/^\d+$/', $value)) {
            throw new DomainException(
                self::class . ' value integer format Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
            );
        }

        if ((int)$value <= 0) {
            throw new DomainException(
                self::class . ' value must be positive'
                . '[value: ' . $value . ']',
            );
        }

        $this->value = (int)$value;
    }
}
