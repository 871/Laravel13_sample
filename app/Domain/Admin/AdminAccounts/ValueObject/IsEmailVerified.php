<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class IsEmailVerified implements Stringable
{
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
            );
        }

        $this->value = (int)$value;
    }
}
