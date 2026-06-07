<?php
declare(strict_types=1);

namespace App\Domain\Log\PageAccessLogs\Repository;

use App\Domain\Log\PageAccessLogs\Entity\PageAccessLog;
use App\Domain\Log\PageAccessLogs\SearchCondition;

interface PageAccessLogsRepository
{
    /**
     * 検索（カーソルベースページネーション、COUNTなし）
     *
     * @param \App\Domain\Log\PageAccessLogs\SearchCondition $condition
     * @return array
     */
    public function search(SearchCondition $condition): array;

    /**
     * 作成
     *
     * @param \App\Domain\Log\PageAccessLogs\Entity\PageAccessLog $entity
     * @return \App\Domain\Log\PageAccessLogs\Entity\PageAccessLog
     */
    public function create(PageAccessLog $entity): PageAccessLog;
}
