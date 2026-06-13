<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process;

use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use DomainException;

final class ProcessRepository implements ApplicationInterface
{
    use ApplicationTrait;

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

        session()->has((string)$sessionKey)
            ? session()->put((string)$sessionKey, $process->getProcessParams()->toArray())
            : throw new DomainException(
                'An invalid Process Instance was set'
                . '[ProcessId: ' . $process->getId()->toString() . ']'
                . '[ProcessParams: ' . print_r($process->getProcessParams()->toArray(), true) . ']',
            );
    }
}
