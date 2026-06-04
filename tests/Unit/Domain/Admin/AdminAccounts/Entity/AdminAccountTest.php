<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\Entity;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use PHPUnit\Framework\TestCase;

final class AdminAccountTest extends TestCase
{
    public function testEntityGettersReturnProvidedVOs(): void
    {
        $id = new Vo\Id('900001');
        $email = new Vo\Email('x@example.com');
        $password = new Vo\Password('secret');
        $name = new Vo\Name('Taro');
        $adminNote = new Vo\AdminNote('note');
        $statusId = new Vo\AccountStatusMasterId('1');
        $statusCode = new Vo\AccountStatusMasterCode(Vo\AccountStatusMasterCode::ACTIVE);
        $statusName = new Vo\AccountStatusMasterName('Active');
        $isVerified = new Vo\IsEmailVerified('1');
        $pwdChanged = new Vo\PasswordChangedAt(null);
        $pwdExpires = new Vo\PasswordExpiresAt(null);

        $createdAt = new SVo\CreatedAt(null);
        $createdBy = new SVo\CreatedBy(null);
        $createdIp = new SVo\CreatedIp(null);
        $modifiedAt = new SVo\ModifiedAt(null);
        $modifiedBy = new SVo\ModifiedBy(null);
        $modifiedIp = new SVo\ModifiedIp(null);

        $entity = new AdminAccount(
            $id,
            $email,
            $password,
            $name,
            $adminNote,
            $statusId,
            $statusCode,
            $statusName,
            $isVerified,
            $pwdChanged,
            $pwdExpires,
            $createdAt,
            $createdBy,
            $createdIp,
            $modifiedAt,
            $modifiedBy,
            $modifiedIp,
        );

        $this->assertSame($id, $entity->id());
        $this->assertSame($email, $entity->email());
        $this->assertSame($password, $entity->password());
        $this->assertSame($name, $entity->name());
        $this->assertSame($adminNote, $entity->adminNote());
        $this->assertSame($statusId, $entity->accountStatusMasterId());
        $this->assertSame($statusCode, $entity->accountStatusMasterCode());
        $this->assertSame($statusName, $entity->accountStatusMasterName());
        $this->assertSame($isVerified, $entity->isEmailVerified());
        $this->assertSame($pwdChanged, $entity->passwordChangedAt());
        $this->assertSame($pwdExpires, $entity->passwordExpiresAt());
        $this->assertSame($createdAt, $entity->createdAt());
        $this->assertSame($createdBy, $entity->createdBy());
        $this->assertSame($createdIp, $entity->createdIp());
        $this->assertSame($modifiedAt, $entity->modifiedAt());
        $this->assertSame($modifiedBy, $entity->modifiedBy());
        $this->assertSame($modifiedIp, $entity->modifiedIp());
    }
}
