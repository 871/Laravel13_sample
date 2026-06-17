<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\ValueObject\Trait\IntTrait;
use DomainException;
use Stringable;

class ModifiedBy implements Stringable
{
    use IntTrait;
    // TODO: 参照: app/Domain/User/UserAccounts/ValueObject/Name.php:25
    public const ERROR_CODE_INVALID_VALUE = 1001;

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
                self::ERROR_CODE_INVALID_VALUE,
            );
        }

        $this->value = (int)$value;
    }
}
