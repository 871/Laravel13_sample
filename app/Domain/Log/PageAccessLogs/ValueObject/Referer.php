<?php
declare(strict_types=1);

namespace App\Domain\Log\PageAccessLogs\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use Stringable;

class Referer implements Stringable
{
    use StringTrait;

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
    }
}
