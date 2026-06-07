<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use App\Domain\Shared\ValueObject\Trait\DateTimeTrait;
use DateTimeImmutable;
use DateTimeInterface;
use DomainException;
use Stringable;

class CreatedAt implements Stringable
{
    use DateTimeTrait;

    /**
     * @var ?\DateTimeInterface
     */
    private readonly ?DateTimeInterface $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value, string $format = 'Y-m-d\\TH:i:s')
    {
        if ($value === null) {
            $this->value = null;

            return;
        }

        // Try primary format first, then some common DB formats
        $formatsToTry = [$format, 'Y-m-d H:i:s', 'Y-m-d\\TH:i:s.u', 'Y-m-d H:i:s.u'];
        $ok = false;
        foreach ($formatsToTry as $f) {
            if (static::checkFormat($value, $f)) {
                $format = $f;
                $ok = true;
                break;
            }
        }

        if (!$ok) {
            throw new DomainException(
                self::class . ' value datetime format Error'
                . '[value: ' . $value . ']'
                . '[format: ' . $format . ']',
            );
        }

        $resultValue = DateTimeImmutable::createFromFormat($format, $value);
        $this->value = $resultValue ?: null;
    }
}
