<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminAccounts\Entity;

use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;

final class AdminAccountHistory
{
    /**
     * @param \App\Domain\Shared\ValueObject\Uuid $id
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\Id $admin_account_id
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\Email $email
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\Name $name
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\AdminNote $admin_note
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterId $account_status_master_id
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterCode $account_status_master_code
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterName $account_status_master_name
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\IsEmailVerified $is_email_verified
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\PasswordChangedAt $password_changed_at
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\PasswordExpiresAt $password_expires_at
     * @param \App\Domain\Shared\ValueObject\CreatedAt $created_at
     * @param \App\Domain\Shared\ValueObject\CreatedBy $created_by
     * @param \App\Domain\Shared\ValueObject\CreatedIp $created_ip
     * @param \App\Domain\Shared\ValueObject\ModifiedAt $modified_at
     * @param \App\Domain\Shared\ValueObject\ModifiedBy $modified_by
     * @param \App\Domain\Shared\ValueObject\ModifiedIp $modified_ip
     * @param \App\Domain\Shared\ValueObject\OperationType $operation_type
     * @param \App\Domain\Shared\ValueObject\HistoryCreated $history_created
     */
    public function __construct(
        private readonly SVo\Uuid $id,
        private readonly Vo\Id $admin_account_id,
        private readonly Vo\Email $email,
        private readonly Vo\Name $name,
        private readonly Vo\AdminNote $admin_note,
        private readonly Vo\AccountStatusMasterId $account_status_master_id,
        private readonly Vo\AccountStatusMasterCode $account_status_master_code,
        private readonly Vo\AccountStatusMasterName $account_status_master_name,
        private readonly Vo\IsEmailVerified $is_email_verified,
        private readonly Vo\PasswordChangedAt $password_changed_at,
        private readonly Vo\PasswordExpiresAt $password_expires_at,
        private readonly SVo\CreatedAt $created_at,
        private readonly SVo\CreatedBy $created_by,
        private readonly SVo\CreatedIp $created_ip,
        private readonly SVo\ModifiedAt $modified_at,
        private readonly SVo\ModifiedBy $modified_by,
        private readonly SVo\ModifiedIp $modified_ip,
        private readonly SVo\OperationType $operation_type,
        private readonly SVo\HistoryCreated $history_created,
    ) {
    }

    /**
     * @return \App\Domain\Shared\ValueObject\Uuid
     */
    public function id(): SVo\Uuid
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\Id
     */
    public function adminAccountId(): Vo\Id
    {
        return $this->admin_account_id;
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\Email
     */
    public function email(): Vo\Email
    {
        return $this->email;
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\Name
     */
    public function name(): Vo\Name
    {
        return $this->name;
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\AdminNote
     */
    public function adminNote(): Vo\AdminNote
    {
        return $this->admin_note;
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

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\IsEmailVerified
     */
    public function isEmailVerified(): Vo\IsEmailVerified
    {
        return $this->is_email_verified;
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\PasswordChangedAt
     */
    public function passwordChangedAt(): Vo\PasswordChangedAt
    {
        return $this->password_changed_at;
    }

    /**
     * @return \App\Domain\Admin\AdminAccounts\ValueObject\PasswordExpiresAt
     */
    public function passwordExpiresAt(): Vo\PasswordExpiresAt
    {
        return $this->password_expires_at;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\CreatedAt
     */
    public function createdAt(): SVo\CreatedAt
    {
        return $this->created_at;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\CreatedBy
     */
    public function createdBy(): SVo\CreatedBy
    {
        return $this->created_by;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\CreatedIp
     */
    public function createdIp(): SVo\CreatedIp
    {
        return $this->created_ip;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\ModifiedAt
     */
    public function modifiedAt(): SVo\ModifiedAt
    {
        return $this->modified_at;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\ModifiedBy
     */
    public function modifiedBy(): SVo\ModifiedBy
    {
        return $this->modified_by;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\ModifiedIp
     */
    public function modifiedIp(): SVo\ModifiedIp
    {
        return $this->modified_ip;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\OperationType
     */
    public function operationType(): SVo\OperationType
    {
        return $this->operation_type;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\HistoryCreated
     */
    public function historyCreated(): SVo\HistoryCreated
    {
        return $this->history_created;
    }
}
