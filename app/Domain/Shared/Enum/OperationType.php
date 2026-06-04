<?php
declare(strict_types=1);

namespace App\Domain\Shared\Enum;

enum OperationType
{
    const INSERT = 'INSERT';
    const UPDATE = 'UPDATE';
    const DELETE = 'DELETE';
}
