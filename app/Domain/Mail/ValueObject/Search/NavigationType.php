<?php
declare(strict_types=1);

namespace App\Domain\Mail\ValueObject\Search;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class NavigationType implements Stringable
{
    use StringTrait;

    public const FIRST = 'first';
    public const LAST = 'last';
    public const NEXT = 'next';
    public const PREV = 'prev';
    public const VALUES = [self::FIRST, self::LAST, self::NEXT, self::PREV];

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        if ($value !== null && !in_array($value, self::VALUES, true)) {
            throw new DomainException(
                self::class . ' value out of range Error'
                . '[value: ' . $value . ']'
                . '[allowed: ' . implode(', ', self::VALUES) . ']',
            );
        }
    }
}
