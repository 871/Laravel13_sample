<?php
declare(strict_types=1);

namespace App\Domain\Log\PageAccessLogs\ValueObject\Search;

use App\Domain\Log\PageAccessLogs\ValueObject as Vo;
use App\Domain\Shared\ValueObject\Trait\IntTrait;
use Stringable;

class AccountId implements Stringable
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

        $this->value = (new Vo\AccountId($value))->toInt();
    }
}
