<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Persistence\Eloquent\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository as Repo;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;

final class AdminAccountsRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed a minimal account_status_master row required by foreign keys
        DB::table('account_status_masters')->insert([
            'id' => 1,
            'code' => 'ACTIVE',
            'name' => 'Active',
            'sort' => 1,
            'is_active' => 1,
            'created' => now(),
            'modified' => now(),
        ]);
    }

    public function testCreateReadFindByEmailReadHistoriesAndUpdate(): void
    {
        $repo = new Repo(new \DateTimeImmutable());

        $id = new Vo\Id('900100');
        $email = new Vo\Email('integ-test@example.com');
        $password = new Vo\Password('secret-password');
        $name = new Vo\Name('Initial Name');
        $adminNote = new Vo\AdminNote('note');
        $statusId = new Vo\AccountStatusMasterId('1');
        $statusCode = new Vo\AccountStatusMasterCode(Vo\AccountStatusMasterCode::ACTIVE);
        $statusName = new Vo\AccountStatusMasterName('Active');
        $isVerified = new Vo\IsEmailVerified('0');
        $pwdChanged = new Vo\PasswordChangedAt(null);
        $pwdExpires = new Vo\PasswordExpiresAt(null);

        $createdAt = new SVo\CreatedAt(null);
        $createdBy = new SVo\CreatedBy(null);
        $createdIp = new SVo\CreatedIp(null);
        $modifiedAt = new SVo\ModifiedAt(null);
        $modifiedBy = new SVo\ModifiedBy(null);
        $modifiedIp = new SVo\ModifiedIp(null);

        $entity = new DomainEntity(
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

        // create
        $created = $repo->create($entity);
        $this->assertSame('integ-test@example.com', $created->email()->toString());
        $this->assertSame('Initial Name', $created->name()->toString());

        // findByEmail
        $found = $repo->findByEmail(new Vo\Email('integ-test@example.com'));
        $this->assertNotNull($found);
        $this->assertSame($created->id()->toString(), $found->id()->toString());

        // readHistories should contain INSERT history
        $histories = $repo->readHistories($id);
        $this->assertNotEmpty($histories);
        $this->assertSame('INSERT', $histories[0]->operationType()->toString());

        // update name
        $updatedName = new Vo\Name('Updated Name');
        $updatedEntity = new DomainEntity(
            $created->id(),
            $created->email(),
            // password null means no change
            new Vo\Password(null),
            $updatedName,
            $created->adminNote(),
            $created->accountStatusMasterId(),
            $created->accountStatusMasterCode(),
            $created->accountStatusMasterName(),
            $created->isEmailVerified(),
            $created->passwordChangedAt(),
            $created->passwordExpiresAt(),
            $created->createdAt(),
            $created->createdBy(),
            $created->createdIp(),
            new SVo\ModifiedAt((new \DateTimeImmutable())->format('Y-m-d\TH:i:s')),
            new SVo\ModifiedBy('1'),
            new SVo\ModifiedIp('127.0.0.1'),
        );

        $afterUpdate = $repo->update($updatedEntity);
        $this->assertSame('Updated Name', $afterUpdate->name()->toString());

        // read histories again should include UPDATE as most recent
        $histories2 = $repo->readHistories($id);
        $this->assertNotEmpty($histories2);
        $this->assertSame('UPDATE', $histories2[0]->operationType()->toString());
    }
}
