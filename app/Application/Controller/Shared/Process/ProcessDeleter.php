<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process;

use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use DomainException;

final class ProcessDeleter implements ApplicationInterface
{
    use ApplicationTrait;

    /**
     * Sessionに保存されたProcess Instance の内容を削除する
     *
     * @param \App\Application\Controller\Shared\Process\ProcessInterface $process
     * @return void
     */
    public function delete(ProcessInterface $process): void
    {
        $sessionKey = new SessionKey(
            prefix: ProcessInterface::PREFIX,
            type: $this->authContext->getType(),
            accountId: $this->authContext->getAccountId(),
            processId: $process->getId(),
        );

        session()->has((string)$sessionKey)
            ? session()->forget((string)$sessionKey)
            : throw new DomainException(
                'An invalid Process Instance was set'
                . '[ProcessId: ' . $process->getId()->toString() . ']',
            );
    }
}
