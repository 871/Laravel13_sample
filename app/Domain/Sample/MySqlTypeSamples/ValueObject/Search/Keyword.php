<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject\Search;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class Keyword implements Stringable
{
    use StringTrait;

    public const MAX_LENGTH = 500;

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        if ($value !== null && mb_strlen($value) > self::MAX_LENGTH) {
            throw new DomainException(
                self::class . ' value text format Error'
                    . '[max length: ' . (string)self::MAX_LENGTH . ']'
                    . '[value: ' . $value . ']',
            );
        }
    }
}
