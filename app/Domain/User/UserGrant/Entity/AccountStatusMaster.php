<?php
declare(strict_types=1);

namespace App\Domain\User\UserGrant\Entity;

use App\Domain\User\UserGrant\ValueObject as Vo;

final class AccountStatusMaster
{
    /**
     * @param \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterId $account_status_master_id
     * @param \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterCode $account_status_master_code
     * @param \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterName $account_status_master_name
     */
    public function __construct(
        private readonly Vo\AccountStatusMasterId $account_status_master_id,
        private readonly Vo\AccountStatusMasterCode $account_status_master_code,
        private readonly Vo\AccountStatusMasterName $account_status_master_name,
    ) {
        // 処理なし
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterId
     */
    public function accountStatusMasterId(): Vo\AccountStatusMasterId
    {
        return $this->account_status_master_id;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterCode
     */
    public function accountStatusMasterCode(): Vo\AccountStatusMasterCode
    {
        return $this->account_status_master_code;
    }

    /**
     * @return \App\Domain\User\UserGrant\ValueObject\AccountStatusMasterName
     */
    public function accountStatusMasterName(): Vo\AccountStatusMasterName
    {
        return $this->account_status_master_name;
    }
}
