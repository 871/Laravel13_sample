<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

class CharCol implements Stringable
{
    use StringTrait;

    public const MATCH = '/^[a-z\d\-]{10}$/i';

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        if ($value !== null && !preg_match(self::MATCH, $value)) {
            throw new DomainException(
                self::class . ' value char format Error'
                . '[match: ' . (string)self::MATCH . ']'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
            );
        }
    }
}
