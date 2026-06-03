<?php
declare(strict_types=1);

namespace App\Domain\Mail\ValueObject\MailBounceLogs;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use Stringable;

class StatusCode implements Stringable
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
