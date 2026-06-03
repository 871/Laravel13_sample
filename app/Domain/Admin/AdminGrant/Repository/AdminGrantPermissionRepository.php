<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\Repository;

use App\Domain\Admin\AdminGrant\SearchAdminGrantPermissionCondition;
use App\Domain\Admin\AdminGrant\ValueObject as Vo;

interface AdminGrantPermissionRepository
{
    /**
     * コンストラクタ
     */
    public function __construct();

    /**
     * 管理者権限の検索
     *
     * @param \App\Domain\Admin\AdminGrant\SearchAdminGrantPermissionCondition $condition
     * @return array<\App\Domain\Admin\AdminGrant\Entity\GrantPermission>
     */
    public function search(SearchAdminGrantPermissionCondition $condition): array;

    /**
     * 管理者が特定の権限を持っているか
     *
     * @param \App\Domain\Admin\AdminGrant\ValueObject\Code $code
     * @param \App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId $accountId
     * @return bool
     */
    public function hasPermission(Vo\Code $code, Vo\AdminAccountId $accountId): bool;
}
