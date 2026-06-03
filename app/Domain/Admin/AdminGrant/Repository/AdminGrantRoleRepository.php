<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminGrant\Repository;

use App\Domain\Admin\AdminGrant\Entity\GrantRole;
use App\Domain\Admin\AdminGrant\SearchAdminGrantRoleCondition;
use App\Domain\Admin\AdminGrant\ValueObject as Vo;
use DateTimeInterface;

interface AdminGrantRoleRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(DateTimeInterface $datetime);

    /**
     * ロール権限の検索
     *
     * @param \App\Domain\Admin\AdminGrant\SearchAdminGrantRoleCondition $condition
     * @return array<\App\Domain\Admin\AdminGrant\Entity\GrantRole>
     */
    public function search(SearchAdminGrantRoleCondition $condition): array;

    /**
     * ロール権限の作成
     *
     * @param \App\Domain\Admin\AdminGrant\Entity\GrantRole $entity
     * @return \App\Domain\Admin\AdminGrant\Entity\GrantRole
     */
    public function create(GrantRole $entity): GrantRole;

    /**
     * ロール権限の取得
     *
     * @param \App\Domain\Admin\AdminGrant\ValueObject\GrantRoleId $id
     * @return \App\Domain\Admin\AdminGrant\Entity\GrantRole
     */
    public function read(Vo\GrantRoleId $id): GrantRole;

    /**
     * ロール権限の更新
     *
     * @param \App\Domain\Admin\AdminGrant\Entity\GrantRole $entity
     * @return \App\Domain\Admin\AdminGrant\Entity\GrantRole
     */
    public function update(GrantRole $entity): GrantRole;

    /**
     * ロール権限の削除
     *
     * @param \App\Domain\Admin\AdminGrant\Entity\GrantRole $entity
     * @return \App\Domain\Admin\AdminGrant\Entity\GrantRole
     */
    public function delete(GrantRole $entity): GrantRole;
}
