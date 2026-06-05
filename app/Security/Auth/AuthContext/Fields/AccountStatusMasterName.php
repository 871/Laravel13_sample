<?php
declare(strict_types=1);

namespace App\Security\Auth\AuthContext\Fields;

class AccountStatusMasterName
{
    /**
     * @var ?string
     */
    private ?string $value;

    /**
     * @param ?string $value
     */
    public function __construct(?string $value)
    {
        if ($value === null || $value === '') {
            $this->value = null;

            return;
        }

        $this->value = $value;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return (string)($this->value ?? '');
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
