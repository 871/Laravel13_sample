<?php
declare(strict_types=1);

namespace App\Domain\Mail\ValueObject\MailReceivedCheckLogs;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use Stringable;

class CheckedAddress implements Stringable
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
