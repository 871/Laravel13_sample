<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\Repository;

use App\Domain\Admin\AdminGrant\Entity\AdminAccountGrant;
use App\Domain\Admin\AdminGrant\SearchAdminAccountGrantCondition;
use App\Domain\Admin\AdminGrant\ValueObject as Vo;
use DateTimeInterface;

interface AdminAccountGrantRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(DateTimeInterface $datetime);

    /**
     * 管理者権限の検索
     *
     * アカウントと権限の組み合わせでユニークなレコードを検索する
     *
     * Memo: Cake5のController::paginate()の仕様を優先した設計とするため、Cake\ORM\Queryを直接返す形にしています。 --- IGNORE ---
     *
     * @param \App\Domain\Admin\AdminGrant\SearchAdminAccountGrantCondition $condition
     * @return \App\Domain\Admin\AdminGrant\Entity\AdminAccountGrant[]
     */
    public function search(SearchAdminAccountGrantCondition $condition): array;

    /**
     * 管理者ステータスマスタの取得
     *
     * @return array<\App\Domain\Admin\AdminGrant\Entity\AccountStatusMaster>
     */
    public function findAccountStatusMasters(): array;

    /**
     * 管理者権限情報の取得
     *
     * 指定した管理者アカウントが保持している権限一覧を取得する（ロール経由・個別付与を含む）
     *
     * @param \App\Domain\Admin\AdminGrant\ValueObject\AdminAccountId $adminAccountId
     * @return \App\Domain\Admin\AdminGrant\Entity\AdminAccountGrant
     */
    public function detail(Vo\AdminAccountId $adminAccountId): AdminAccountGrant;

    /**
     * 管理者権限の設定（ロール、個別を同時）
     *
     * 指定した管理者アカウントのロール付与と個別権限付与を一括で設定する（既存設定は削除して再設定）
     *
     * @param \App\Domain\Admin\AdminGrant\Entity\AdminAccountGrant $adminAccountGrant
     * @return \App\Domain\Admin\AdminGrant\Entity\AdminAccountGrant
     */
    public function save(AdminAccountGrant $adminAccountGrant): AdminAccountGrant;
}
