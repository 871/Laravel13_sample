<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use App\Lib\UUID\UUID as LibUUID;
use DomainException;
use Stringable;

class Uuid implements Stringable
{
    use StringTrait;

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
            );
        }

        $this->value = $value;
    }
}
