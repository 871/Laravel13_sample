<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process\Process\Fields;

use DomainException;
use Stringable;

final class ProcessId implements Stringable
{
    public const LENGTH = 15;

    /**
     * @var string
     */
    private string $value;

    /**
     * @param string $process_id
     */
    public function __construct(
        private readonly string $process_id,
    ) {
        strlen($process_id) <= self::LENGTH && preg_match('/^[a-z0-9]+$/', $process_id)
        || throw new DomainException(
            self::class . ' process_id length Error'
                . '[maxlength: ' . (string)self::LENGTH . ']'
                . '[process_id: ' . (string)$process_id . ']',
        );

        $this->value = str_pad($this->process_id, self::LENGTH, '0', STR_PAD_LEFT);
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
