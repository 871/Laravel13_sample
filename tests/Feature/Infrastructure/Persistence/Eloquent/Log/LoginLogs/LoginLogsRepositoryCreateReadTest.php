<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Persistence\Eloquent\Log\LoginLogs;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;
use App\Domain\Log\LoginLogs\Entity\LoginLog as LoginLogEntity;
use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Domain\Shared\ValueObject\CreatedAt;

/**
 * ./vendor/bin/sail artisan test --filter=LoginLogsRepositoryCreateReadTest
 */
final class LoginLogsRepositoryCreateReadTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        if (! app()->environment('testing')) {
            throw new \RuntimeException('Testing environment only.');
        }

        if (config('database.connections.mysql.database') !== 'testing') {
            throw new \RuntimeException(
                'Refusing to run tests against database: '
                . config('database.connections.mysql.database')
            );
        }
    }

    protected function tearDown(): void
    {
        parent::tearDown();
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
