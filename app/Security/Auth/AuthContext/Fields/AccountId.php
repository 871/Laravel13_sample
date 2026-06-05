<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields;

use Stringable;

interface AccountId extends Stringable
{
    /**
     * @param string $value
     */
    public function __construct(string $value);

    /**
     * @return int
     */
    public function toInt(): int;

    /**
     * @return string
     */
    public function toString(): string;

    /**
     * @return string
     */
    public function __toString(): string;
}
