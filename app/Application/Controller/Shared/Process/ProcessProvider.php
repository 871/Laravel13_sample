<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process;

use App\Application\Controller\Shared\Process\Process\Fields\ProcessId;
use App\Application\Controller\Shared\Process\Process\Fields\ProcessParams;
use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use DomainException;

final class ProcessProvider implements ApplicationInterface
{
    use ApplicationTrait;

    /**
     * Sessionに保存されたProcessInstanceの内容からProcessInstanceを取得する
     *
     * @param string $processClassName
     * @param \App\Application\Controller\Shared\Process\Process\Fields\ProcessId $processId
     * @return ?\App\Application\Controller\Shared\Process\ProcessInterface
     */
    public function provide(string $processClassName, ProcessId $processId): ?ProcessInterface
    {
        if (!is_subclass_of($processClassName, ProcessInterface::class)) {
            throw new DomainException(
                'Process class must implement ' . ProcessInterface::class
                . '[processClassName: ' . $processClassName . ']',
            );
        }

        $processParams = $this->getProcessParams($processId);

        return $processParams === null ? null : new $processClassName(
            processId: $processId,
            processParams: $processParams,
        );
    }

    /**
     * @param \App\Application\Controller\Shared\Process\Process\Fields\ProcessId $processId
     * @return ?\App\Application\Controller\Shared\Process\Process\Fields\ProcessParams
     */
    private function getProcessParams(ProcessId $processId): ?ProcessParams
    {
        $sessionKey = new SessionKey(
            prefix: ProcessInterface::PREFIX,
            type: $this->authContext->getType(),
            accountId: $this->authContext->getAccountId(),
            processId: $processId,
        );

        return session()->has((string)$sessionKey)
            ? new ProcessParams((array)session()->get((string)$sessionKey))
            : null;
    }
}
