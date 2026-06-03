<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class Sort implements Stringable
{
    use IntTrait;

    private ?int $value;

    public const ERROR_CODE_INTEGER_FORMAT = 1001;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        if ($value === null || $value === '') {
            $this->value = null;

            return;
        }

        if (!preg_match('/^-?\d{1,10}$/', $value)) {
            throw new DomainException(
                message: self::class . ' value integer format Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                code: self::ERROR_CODE_INTEGER_FORMAT,
            );
        }

        $this->value = (int)$value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return (string)$this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
