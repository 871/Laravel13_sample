<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\ValueObject;

use App\Domain\Shared\ValueObject\Trait\JsonTrait;
use DomainException;
use JsonException;
use Stringable;

class JsonCol implements Stringable
{
    use JsonTrait;

    public const ERROR_CODE_INVALID_FORMAT = 1001;
    public const ERROR_CODE_MAX_BYTE_EXCEEDED = 1002;

    public const MAX_BYTE = 1048567; // 1MB(1024 * 2024)

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        if ($value === null) {
            $this->value = null;

            return;
        }

        if (strlen($value) > self::MAX_BYTE) {
            throw new DomainException(
                self::class . ' JSON size exceeded'
                . '[max byte: ' . self::MAX_BYTE . ']'
                . '[value: ' . $value . ']',
                self::ERROR_CODE_MAX_BYTE_EXCEEDED,
            );
        }

        try {
            $this->value = (array)json_decode($value, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            throw new DomainException(
                self::class . ' JSON decode failed: ' . $e->getMessage()
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_INVALID_FORMAT,
            );
        }
    }
}
