<?php
declare(strict_types=1);

namespace App\Domain\Mail\ValueObject\Search;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use Stringable;

class SearchKey implements Stringable
{
    use StringTrait;

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        // 処理なし
    }
}
