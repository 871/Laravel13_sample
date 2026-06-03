<?php
declare(strict_types=1);

namespace App\Domain\User\UserAccounts\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class Id implements Stringable
{
    use IntTrait;

    /**
     * @param ?string $value
     */
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

        if (!preg_match('/^[1-9]\d*$/', $value)) {
            throw new DomainException(
                self::class . ' value integer format Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
            );
        }

        $this->value = $value;
    }
}
