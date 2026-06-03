<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminAccounts\ValueObject\Search;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use Stringable;

class Keyword implements Stringable
{
    use StringTrait;

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
    }

    /**
     * @return ?string
     */
    public function toQueryLikeOrNull(): ?string
    {
        return $this->value !== null ? '%' . $this->value . '%' : null;
    }
}
