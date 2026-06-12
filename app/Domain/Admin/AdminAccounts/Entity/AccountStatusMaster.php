<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminAccounts\Entity;

use App\Domain\Admin\AdminAccounts\ValueObject as Vo;

final class AccountStatusMaster
{
    /**
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterId $account_status_master_id
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterCode $account_status_master_code
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterName $account_status_master_name
     */
    public function __construct(
        private readonly Vo\AccountStatusMasterId $account_status_master_id,
        private readonly Vo\AccountStatusMasterCode $account_status_master_code,
        private readonly Vo\AccountStatusMasterName $account_status_master_name
    ) {
        // 処理なし
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterId
     */
    public function accountStatusMasterId(): Vo\AccountStatusMasterId
    {
        return $this->account_status_master_id;
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterCode
     */
    public function accountStatusMasterCode(): Vo\AccountStatusMasterCode
    {
        return $this->account_status_master_code;
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterName
     */
    public function accountStatusMasterName(): Vo\AccountStatusMasterName
    {
        return $this->account_status_master_name;
    }
}
