<?php
declare(strict_types=1);

namespace App\Domain\Log\LoginLogs\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class ImpersonatorAccountId implements Stringable
{
    use IntTrait;

    public const MIN = 1;

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

        if (!preg_match('/^\d+$/', $value) || (int)$value < self::MIN) {
            throw new DomainException(
                self::class . ' value range Error'
                . '[value: ' . $value . ']',
            );
        }

        $this->value = (int)$value;
    }
}
