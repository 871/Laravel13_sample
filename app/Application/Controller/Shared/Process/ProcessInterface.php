<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process;

interface ProcessInterface
{
    public const PREFIX = 'process';

    /**
     * @param \App\Application\Controller\Shared\Process\Process\Fields\ProcessId $processId
     * @param \App\Application\Controller\Shared\Process\Process\Fields\ProcessParams $processParams
     */
    public function __construct(
        Process\Fields\ProcessId $processId,
        Process\Fields\ProcessParams $processParams,
    );

    /**
     * @param \App\Application\Controller\Shared\Process\Process\Fields\ProcessParams $processParams
     * @return self
     */
    public function setProcessParams(Process\Fields\ProcessParams $processParams): self;

    /**
     * @return \App\Application\Controller\Shared\Process\Process\Fields\ProcessId
     */
    public function getId(): Process\Fields\ProcessId;

    /**
     * @return \App\Application\Controller\Shared\Process\Process\Fields\ProcessParams
     */
    public function getProcessParams(): Process\Fields\ProcessParams;
}
