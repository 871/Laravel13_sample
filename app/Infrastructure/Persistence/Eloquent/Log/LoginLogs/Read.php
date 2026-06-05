<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Log\LoginLogs;

use App\Domain\Log\LoginLogs\ValueObject as Vo;

final class Read
{
    public function run(Vo\Id $id)
    {
        $m = \App\Models\Log\LoginLog::query()->findOrFail($id->toString());

        return Mapper::mapModelToDomain($m);
    }
}
