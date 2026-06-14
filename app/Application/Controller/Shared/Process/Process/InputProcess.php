<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process\Process;

use App\Application\Controller\Shared\Process\ProcessInterface;
use Illuminate\Support\Arr;

final class InputProcess implements ProcessInterface
{
    /**
     * @param \App\Application\Controller\Shared\Process\Process\Fields\ProcessId $processId
     * @param \App\Application\Controller\Shared\Process\Process\Fields\ProcessParams $processParams
     */
    public function __construct(
        private readonly Fields\ProcessId $processId,
        private readonly Fields\ProcessParams $processParams,
    ) {
        // 処理なし
    }

    /**
     * @param \App\Application\Controller\Shared\Process\Process\Fields\ProcessParams $processParams
     * @return self
     */
    public function setProcessParams(Fields\ProcessParams $processParams): self
    {
        return new self($this->processId, $processParams);
    }

    /**
     * @return \App\Application\Controller\Shared\Process\Process\Fields\ProcessId
     */
    public function getId(): Fields\ProcessId
    {
        return $this->processId;
    }

    /**
     * @return \App\Application\Controller\Shared\Process\Process\Fields\ProcessParams
     */
    public function getProcessParams(): Fields\ProcessParams
    {
        return $this->processParams;
    }

    /**
     * @return array<string, mixed>
     */
    public function getInputs(): array
    {
        $fnc = function($value) use (&$fnc) {
            if ($value === []) {
                return [];
            }
            if (is_array($value)) {
                return array_map($fnc, $value);
            }
            return (string)$value;
        };

        return array_map($fnc, $this->processParams->toArray());
    }

    /**
     * @param string $path
     * @param ?string $default
     * @return mixed
     */
    public function getInput(string $path, ?string $default = null): mixed
    {
        return Arr::get($this->getInputs(), $path, $default);
    }
}
