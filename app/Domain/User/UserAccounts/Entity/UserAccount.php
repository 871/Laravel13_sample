<?php
declare(strict_types=1);

namespace App\Domain\User\UserAccounts\Entity;

use App\Domain\Shared\ValueObject as SVo;
use App\Domain\User\UserAccounts\ValueObject as Vo;

final class UserAccount
{
    /**
     * @param \App\Domain\User\UserAccounts\ValueObject\Id $id
     * @param \App\Domain\User\UserAccounts\ValueObject\Email $email
     * @param \App\Domain\User\UserAccounts\ValueObject\Password $password
     * @param \App\Domain\User\UserAccounts\ValueObject\Name $name
     * @param \App\Domain\User\UserAccounts\ValueObject\AccountStatusMasterId $account_status_master_id
     * @param \App\Domain\User\UserAccounts\ValueObject\AccountStatusMasterCode $account_status_master_code
     * @param \App\Domain\User\UserAccounts\ValueObject\AccountStatusMasterName $account_status_master_name
     * @param \App\Domain\User\UserAccounts\ValueObject\IsEmailVerified $is_email_verified
     * @param \App\Domain\User\UserAccounts\ValueObject\PasswordChangedAt $password_changed_at
     * @param \App\Domain\User\UserAccounts\ValueObject\PasswordExpiresAt $password_expires_at
     * @param \App\Domain\Shared\ValueObject\Created $created_at
     * @param \App\Domain\Shared\ValueObject\CreatedBy $created_by
     * @param \App\Domain\Shared\ValueObject\CreatedIp $created_ip
     * @param \App\Domain\Shared\ValueObject\Modified $modified_at
     * @param \App\Domain\Shared\ValueObject\ModifiedBy $modified_by
     * @param \App\Domain\Shared\ValueObject\ModifiedIp $modified_ip
     */
    public function __construct(
        private readonly Vo\Id $id,
        private readonly Vo\Email $email,
        private readonly Vo\Password $password,
        private readonly Vo\Name $name,
        private readonly Vo\AccountStatusMasterId $account_status_master_id,
        private readonly Vo\AccountStatusMasterCode $account_status_master_code,
        private readonly Vo\AccountStatusMasterName $account_status_master_name,
        private readonly Vo\IsEmailVerified $is_email_verified,
        private readonly Vo\PasswordChangedAt $password_changed_at,
        private readonly Vo\PasswordExpiresAt $password_expires_at,
        private readonly SVo\CreatedAt $created_at,
        private readonly SVo\CreatedAtBy $created_by,
        private readonly SVo\CreatedAtIp $created_ip,
        private readonly SVo\ModifiedAt $modified_at,
        private readonly SVo\ModifiedAtBy $modified_by,
        private readonly SVo\ModifiedAtIp $modified_ip,
    ) {
        // 処理なし
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\Id
     */
    public function id(): Vo\Id
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\Email
     */
    public function email(): Vo\Email
    {
        return $this->email;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\Password
     */
    public function password(): Vo\Password
    {
        return $this->password;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\Name
     */
    public function name(): Vo\Name
    {
        return $this->name;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\AccountStatusMasterId
     */
    public function accountStatusMasterId(): Vo\AccountStatusMasterId
    {
        return $this->account_status_master_id;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\AccountStatusMasterCode
     */
    public function accountStatusMasterCode(): Vo\AccountStatusMasterCode
    {
        return $this->account_status_master_code;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\AccountStatusMasterName
     */
    public function accountStatusMasterName(): Vo\AccountStatusMasterName
    {
        return $this->account_status_master_name;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\IsEmailVerified
     */
    public function isEmailVerified(): Vo\IsEmailVerified
    {
        return $this->is_email_verified;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\PasswordChangedAt
     */
    public function passwordChangedAt(): Vo\PasswordChangedAt
    {
        return $this->password_changed_at;
    }

    /**
     * @return \App\Domain\User\UserAccounts\ValueObject\PasswordExpiresAt
     */
    public function passwordExpiresAt(): Vo\PasswordExpiresAt
    {
        return $this->password_expires_at;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\Created
     */
    public function createdAt(): SVo\CreatedAt
    {
        return $this->created_at;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\CreatedBy
     */
    public function createdBy(): SVo\CreatedAtBy
    {
        return $this->created_by;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\CreatedIp
     */
    public function createdIp(): SVo\CreatedAtIp
    {
        return $this->created_ip;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\Modified
     */
    public function modifiedAt(): SVo\ModifiedAt
    {
        return $this->modified_at;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\ModifiedBy
     */
    public function modifiedBy(): SVo\ModifiedAtBy
    {
        return $this->modified_by;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\ModifiedIp
     */
    public function modifiedIp(): SVo\ModifiedAtIp
    {
        return $this->modified_ip;
    }
}
