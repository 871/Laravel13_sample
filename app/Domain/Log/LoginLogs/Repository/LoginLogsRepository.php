<?php
declare(strict_types=1);

namespace App\Domain\Log\LoginLogs\Repository;

use App\Domain\Log\LoginLogs\Entity\LoginLog;
use App\Domain\Log\LoginLogs\SearchCondition;
use App\Domain\Log\LoginLogs\ValueObject as Vo;

interface LoginLogsRepository
{
    /**
     * Memo: Cake5のController::paginate()の仕様を優先した設計とするため、Cake\ORM\Queryを直接返す形にしています。 --- IGNORE ---
     * 完全なDDDへ再設計する場合は、ドメインサービス内でページネーションやソートの処理も完結させる形にすることも検討してください。 --- IGNORE ---
     *
     * @param \App\Domain\Log\LoginLogs\SearchCondition $condition
     * @return \App\Domain\Log\LoginLogs\Entity\LoginLog[]
     */
    public function search(SearchCondition $condition): array;

    /**
     * 作成
     *
     * @param \App\Domain\Log\LoginLogs\Entity\LoginLog $entity
     * @return \App\Domain\Log\LoginLogs\Entity\LoginLog
     */
    public function create(LoginLog $entity): LoginLog;

    /**
     * 取得
     *
     * @param \App\Domain\Log\LoginLogs\ValueObject\Id $id
     * @return \App\Domain\Log\LoginLogs\Entity\LoginLog
     */
    public function read(Vo\Id $id): LoginLog;

    /**
     * ログイン失敗回数超過チェック
     *
     * @param \App\Domain\Log\LoginLogs\ValueObject\LoginId $loginId
     * @return bool
     */
    public function checkFailureLoginLimit(Vo\LoginId $loginId): bool;
}
