<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process;

use App\Application\Controller\Shared\ServiceInterface;
use App\Application\Controller\Shared\ServiceTrait;
use DomainException;

final class ProcessRepository implements ServiceInterface
{
    use ServiceTrait;

    /**
     * Process Instance の内容をSessionに保存する
     *
     * @param \App\Application\Controller\Shared\Process\ProcessInterface $process
     * @return void
     */
    public function save(ProcessInterface $process): void
    {
        $sessionKey = new SessionKey(
            prefix: ProcessInterface::PREFIX,
            type: $this->authContext->getType(),
            accountId: $this->authContext->getAccountId(),
            processId: $process->getId(),
        );

        $this->request->getSession()->check((string)$sessionKey)
            ? $this->request->getSession()->write((string)$sessionKey, $process->getProcessParams()->toArray())
            : throw new DomainException(
                'An invalid Process Instance was set'
                . '[ProcessId: ' . $process->getId()->toString() . ']'
                . '[ProcessParams: ' . print_r($process->getProcessParams()->toArray(), true) . ']',
            );
    }
}
