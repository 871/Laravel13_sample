<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Persistence\Eloquent\Log\LoginLogs;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;
use App\Domain\Log\LoginLogs\Entity\LoginLog as LoginLogEntity;
use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Domain\Shared\ValueObject\CreatedAt;

final class LoginLogsRepositoryCreateReadTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    private function makeEntity(array $overrides = []): LoginLogEntity
    {
        $id = $overrides['id'] ?? Str::uuid()->toString();
        $loginId = $overrides['login_id'] ?? ('user-' . substr($id, 0, 8));
        $actor = $overrides['login_actor_type'] ?? Vo\LoginActorType::ADMIN;
        $accountId = array_key_exists('account_id', $overrides) ? $overrides['account_id'] : null;
        $impersonatorId = array_key_exists('impersonator_account_id', $overrides) ? $overrides['impersonator_account_id'] : null;
        $result = $overrides['login_result'] ?? Vo\LoginResult::SUCCESS;
        $ip = $overrides['ip_address'] ?? '127.0.0.1';
        $ua = $overrides['user_agent'] ?? 'PHPUnit';
        $failure = array_key_exists('failure_reason_code', $overrides) ? $overrides['failure_reason_code'] : null;
        $now = $overrides['logged_in_at'] ?? now()->format('Y-m-d\TH:i:s');
        $created = $overrides['created_at'] ?? now()->format('Y-m-d\TH:i:s');

        return new LoginLogEntity(
            new Vo\Id($id),
            new Vo\LoginId($loginId),
            new Vo\LoginActorType($actor),
            new Vo\AccountId($accountId !== null ? (string)$accountId : null),
            new Vo\ImpersonatorAccountId($impersonatorId !== null ? (string)$impersonatorId : null),
            new Vo\LoginResult($result),
            new Vo\IpAddress($ip),
            new Vo\UserAgent($ua),
            new Vo\FailureReasonCode($failure),
            new Vo\LoggedInAt($now),
            new CreatedAt($created),
        );
    }

    public function test_create_and_read()
    {
        $datetime = new \DateTimeImmutable();
        $entity = new LoginLogEntity(
            new Vo\Id(Str::uuid()->toString()),
            new Vo\LoginId('testuser@test.test'),
            new Vo\LoginActorType(Vo\LoginActorType::ADMIN),
            new Vo\AccountId(null),
            new Vo\ImpersonatorAccountId(null),
            new Vo\LoginResult(Vo\LoginResult::FAILURE),
            new Vo\IpAddress('127.0.0.1'),
            new Vo\UserAgent('PHPUnit'),
            new Vo\FailureReasonCode(Vo\FailureReasonCode::LOGIN_ID_NOT_FOUND),
            new Vo\LoggedInAt($datetime->format('Y-m-d\TH:i:s')),
            new CreatedAt($datetime->format('Y-m-d\TH:i:s')),
        );

        $repo = new LoginLogsRepository($datetime);

        $created = $repo->create($entity);
        $this->assertSame($entity->id()->toString(), $created->id()->toString());
        $this->assertSame($entity->loginId()->toString(), $created->loginId()->toString());

        $read = $repo->read($entity->id());
        $this->assertSame($created->id()->toString(), $read->id()->toString());
        $this->assertSame($created->loginResult()->toString(), $read->loginResult()->toString());
    }
}
