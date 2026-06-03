<?php
declare(strict_types=1);

namespace App\Domain\Log\LoginLogs\ValueObject\Search;

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

    /**
     * @return array<string>
     */
    public function toQueryLikeList(): array
    {
        return array_map(
            fn($word) => '%' . $word . '%',
            array_filter(
                preg_split('/\s+/', $this->value ?? '') ?: [],
                fn($word) => $word !== '',
            ),
        );
    }
}
