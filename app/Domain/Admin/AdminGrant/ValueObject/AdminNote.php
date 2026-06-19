<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use Stringable;

class AdminNote implements Stringable, ValueObjectInterface {
    use StringTrait;

    private ?string $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        $this->value = $value === null || $value === '' ? null : $value;
    }
}
