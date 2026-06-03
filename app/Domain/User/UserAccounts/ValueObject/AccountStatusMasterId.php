<?php
declare(strict_types=1);

namespace App\Domain\User\UserAccounts\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class AccountStatusMasterId implements Stringable
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
                . '[value: ' . $value . ']',
            );
        }

        $this->value = (int)$value;
    }
}
