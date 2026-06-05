<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields;

use App\Domain\Shared\ValueObject as Svo;
use DateTimeInterface;
use DomainException;
use Stringable;

class Modified implements Stringable
{
    /**
     * @var ?\DateTimeInterface
     */
    private readonly ?DateTimeInterface $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value, string $format = 'Y-m-d\TH:i:s')
    {
        if ($value === null) {
            $this->value = null;

            return;
        }

        $this->value = (new Svo\Modified($value, $format))->toDateTimeOrNull() ?? throw new DomainException(
            self::class . ' Generate Error'
            . '[value: ' . $value . ']'
            . '[format: ' . $format . ']',
        );
    }

    /**
     * @return ?\DateTimeInterface
     */
    public function toDateTimeOrNull(): ?DateTimeInterface
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->value?->format('Y-m-d\TH:i:s') ?? '';
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
