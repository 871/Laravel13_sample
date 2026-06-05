<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process;

use App\Application\Controller\Shared\ServiceInterface;
use App\Application\Controller\Shared\ServiceTrait;
use DomainException;

final class ProcessDeleter implements ServiceInterface
{
    use ServiceTrait;

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

        $this->request->getSession()->check((string)$sessionKey)
            ? $this->request->getSession()->delete((string)$sessionKey)
            : throw new DomainException(
                'An invalid Process Instance was set'
                . '[ProcessId: ' . $process->getId()->toString() . ']',
            );
    }
}
