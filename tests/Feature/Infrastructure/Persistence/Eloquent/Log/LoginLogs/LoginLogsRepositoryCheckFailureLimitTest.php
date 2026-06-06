<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Persistence\Eloquent\Log\LoginLogs;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;
use App\Domain\Log\LoginLogs\Entity\LoginLog as LoginLogEntity;
use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Domain\Shared\ValueObject\CreatedAt as SCreatedAt;

final class LoginLogsRepositoryCheckFailureLimitTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Run migrations into the prepared test DB connection
        $conn = env('TEST_DB_CONNECTION') ?: (env('DB_CONNECTION') ?: config('database.default'));
        $available = array_keys(config('database.connections'));
        if (!in_array($conn, $available, true)) {
            $this->fail(sprintf('Database connection [%s] not configured. Available: %s', $conn, implode(', ', $available)));
        }

        $this->artisan('migrate:fresh', ['--database' => $conn]);

        if (!Schema::hasTable('login_logs')) {
            $this->fail('login_logs table not created by migrations in test database');
        }
    }

    protected function tearDown(): void
    {
        $conn = env('TEST_DB_CONNECTION') ?: (env('DB_CONNECTION') ?: config('database.default'));
        $this->artisan('migrate:reset', ['--database' => $conn]);

        parent::tearDown();
    }

    private function makeEntity(array $overrides = []): LoginLogEntity
    {
        $id = $overrides['id'] ?? Str::uuid()->toString();
        $loginId = $overrides['login_id'] ?? ('user-' . substr($id, 0, 8));
        $actor = $overrides['login_actor_type'] ?? Vo\LoginActorType::ADMIN;
        $accountId = array_key_exists('account_id', $overrides) ? $overrides['account_id'] : null;
        $impersonatorId = array_key_exists('impersonator_account_id', $overrides) ? $overrides['impersonator_account_id'] : null;
        $result = $overrides['login_result'] ?? Vo\LoginResult::FAILURE;
        $ip = $overrides['ip_address'] ?? '127.0.0.1';
        $ua = $overrides['user_agent'] ?? 'PHPUnit';
        $failure = array_key_exists('failure_reason_code', $overrides) ? $overrides['failure_reason_code'] : Vo\FailureReasonCode::INVALID_PASSWORD;
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
            new SCreatedAt($created),
        );
    }

    public function test_threshold_blocks_and_resets_after_success()
    {
        // Set small threshold for test
        $this->app['config']->set('auth.login_failure_threshold', 3);
        $this->app['config']->set('auth.login_failure_minutes', 15);

        $now = new \DateTimeImmutable();
        $repo = new LoginLogsRepository($now);
        $loginId = 'attacker-checklimit';

        // Ensure initial allowed
        $this->assertTrue($repo->checkFailureLoginLimit(new Vo\LoginId($loginId)));

        // Record failures up to threshold-1 and assert allowed
        for ($i = 1; $i < 3; $i++) {
            $e = $this->makeEntity(['login_id' => $loginId, 'login_result' => Vo\LoginResult::FAILURE, 'failure_reason_code' => Vo\FailureReasonCode::INVALID_PASSWORD, 'logged_in_at' => $now->format('Y-m-d\TH:i:s')]);
            $repo->create($e);
            $this->assertTrue($repo->checkFailureLoginLimit(new Vo\LoginId($loginId)), "Expected allowed after $i failures");
        }

        // Record the threshold-th failure -> should now be blocked (false)
        $eThreshold = $this->makeEntity(['login_id' => $loginId, 'login_result' => Vo\LoginResult::FAILURE, 'failure_reason_code' => Vo\FailureReasonCode::INVALID_PASSWORD, 'logged_in_at' => $now->format('Y-m-d\TH:i:s')]);
        $repo->create($eThreshold);
        $this->assertFalse($repo->checkFailureLoginLimit(new Vo\LoginId($loginId)), 'Expected blocked when failures reach threshold');

        // Record a success log -> should reset allow (true)
        $eSuccess = $this->makeEntity(['login_id' => $loginId, 'login_result' => Vo\LoginResult::SUCCESS, 'failure_reason_code' => null, 'logged_in_at' => $now->format('Y-m-d\TH:i:s')]);
        $repo->create($eSuccess);
        $this->assertTrue($repo->checkFailureLoginLimit(new Vo\LoginId($loginId)), 'Expected allowed after a success log');

        // Again record failures up to threshold to ensure blocking resumes
        for ($i = 1; $i <= 3; $i++) {
            $e = $this->makeEntity(['login_id' => $loginId, 'login_result' => Vo\LoginResult::FAILURE, 'failure_reason_code' => Vo\FailureReasonCode::INVALID_PASSWORD, 'logged_in_at' => $now->format('Y-m-d\TH:i:s')]);
            $repo->create($e);
        }

        $this->assertFalse($repo->checkFailureLoginLimit(new Vo\LoginId($loginId)), 'Expected blocked after failures again reach threshold');
    }
}
