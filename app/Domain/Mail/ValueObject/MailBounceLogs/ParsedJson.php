<?php
declare(strict_types=1);

namespace App\Domain\Mail\ValueObject\MailBounceLogs;

use App\Domain\Shared\ValueObject\Trait\JsonTrait;
use DomainException;
use JsonException;
use Stringable;

class ParsedJson implements Stringable
{
    use JsonTrait;

    /**
     * @var ?array<mixed>
     */
    private readonly ?array $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        if ($value === null) {
            $this->value = null;

            return;
        }

        try {
            $decoded = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            if (!is_array($decoded)) {
                throw new DomainException(
                    self::class . ' JSON must decode to array'
                    . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                );
            }
            $this->value = $decoded;
        } catch (JsonException $e) {
            throw new DomainException(
                self::class . ' JSON decode failed: ' . $e->getMessage()
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
            );
        }
    }
}
