<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process;

use Exception;

class ProcessNotFoundException extends Exception
{
    /**
     * @param string $processId
     */
    public function __construct(
        string $processId,
    ) {
        parent::__construct('Process not found. [processId: ' . $processId . ']');
    }
}
