<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\Entity;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccountHistory;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;
use PHPUnit\Framework\TestCase;

final class AdminAccountHistoryTest extends TestCase
{
    public function testGettersReturnProvidedVOs(): void
    {
        $uuid = new SVo\Uuid('123e4567-e89b-12d3-a456-426655440000');
        $id = new Vo\Id('900002');
        $email = new Vo\Email('hoge@example.com');
        $name = new Vo\Name('Hanako');
        $adminNote = new Vo\AdminNote('note');
        $statusId = new Vo\AccountStatusMasterId('2');
        $statusCode = new Vo\AccountStatusMasterCode(Vo\AccountStatusMasterCode::SUSPENDED);
        $statusName = new Vo\AccountStatusMasterName('Suspended');
        $isVerified = new Vo\IsEmailVerified('0');
        $pwdChanged = new Vo\PasswordChangedAt(null);
        $pwdExpires = new Vo\PasswordExpiresAt(null);

        $createdAt = new SVo\CreatedAt('2026-06-04T12:00:00');
        $createdBy = new SVo\CreatedBy('1');
        $createdIp = new SVo\CreatedIp('127.0.0.1');
        $modifiedAt = new SVo\ModifiedAt('2026-06-04T12:30:00');
        $modifiedBy = new SVo\ModifiedBy('2');
        $modifiedIp = new SVo\ModifiedIp('127.0.0.2');
        $operationType = new SVo\OperationType(SVo\OperationType::DELETE);
        $historyCreated = new SVo\HistoryCreated('2026-06-04T12:45:00');

        $history = new AdminAccountHistory(
            $uuid,
            $id,
            $email,
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
            $operationType,
            $historyCreated,
        );

        $this->assertSame($uuid, $history->id());
        $this->assertSame($id, $history->adminAccountId());
        $this->assertSame($email, $history->email());
        $this->assertSame($name, $history->name());
        $this->assertSame($adminNote, $history->adminNote());
        $this->assertSame($statusId, $history->accountStatusMasterId());
        $this->assertSame($statusCode, $history->accountStatusMasterCode());
        $this->assertSame($statusName, $history->accountStatusMasterName());
        $this->assertSame($isVerified, $history->isEmailVerified());
        $this->assertSame($pwdChanged, $history->passwordChangedAt());
        $this->assertSame($pwdExpires, $history->passwordExpiresAt());
        $this->assertSame($createdAt, $history->createdAt());
        $this->assertSame($createdBy, $history->createdBy());
        $this->assertSame($createdIp, $history->createdIp());
        $this->assertSame($modifiedAt, $history->modifiedAt());
        $this->assertSame($modifiedBy, $history->modifiedBy());
        $this->assertSame($modifiedIp, $history->modifiedIp());
        $this->assertSame($operationType, $history->operationType());
        $this->assertSame($historyCreated, $history->historyCreated());
    }
}
