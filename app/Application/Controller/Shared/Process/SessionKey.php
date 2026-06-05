<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process;

use App\Security\Auth\AuthContext\Fields;
use Stringable;

final class SessionKey implements Stringable
{
    /**
     * @param string $prefix
     * @param \App\Security\Auth\AuthContext\Fields\Type $type
     * @param ?\App\Security\Auth\AuthContext\Fields\AccountId $accountId
     * @param \App\Application\Controller\Shared\Process\Process\Fields\ProcessId $processId
     */
    public function __construct(
        private readonly string $prefix,
        private readonly Fields\Type $type,
        private readonly ?Fields\AccountId $accountId,
        private readonly Process\Fields\ProcessId $processId,
    ) {
        //　処理なし
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return join('.', array_filter([
            $this->prefix,
            $this->type->toString(),
            $this->accountId?->toInt(),
            $this->processId->toString(),
        ], fn($v) => $v !== null));
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }
}
