<?php

namespace Tests\Feature\Infrastructure\Persistence\Eloquent\Log;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Str;
use App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;
use App\Domain\Log\LoginLogs\Entity\LoginLog as LoginLogEntity;
use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Domain\Log\LoginLogs\ValueObject\Search\Keyword as SearchKeyword;

class LoginLogsRepositoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure tests run on in-memory sqlite to avoid requiring MySQL
        $this->app['config']->set('database.default', 'sqlite');
        $this->app['config']->set('database.connections.sqlite.database', ':memory:');

        if (Schema::hasTable('login_logs')) {
            Schema::drop('login_logs');
        }

        Schema::create('login_logs', function (Blueprint $table) {
            $table->char('id', 36)->primary();
            $table->string('login_id', 255);
            $table->string('login_actor_type', 20);
            $table->unsignedBigInteger('account_id')->nullable();
            $table->unsignedBigInteger('impersonator_account_id')->nullable();
            $table->string('login_result', 20);
            $table->string('ip_address', 45);
            $table->text('user_agent')->nullable();
            $table->string('failure_reason_code')->nullable();
            $table->dateTime('logged_in_at');
            $table->dateTime('created_at')->nullable();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('login_logs');

        parent::tearDown();
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
        $failure = $overrides['failure_reason_code'] ?? null;
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
            new \App\Domain\Shared\ValueObject\CreatedAt($created),
        );
    }

    public function test_create_and_read()
    {
        $repo = new LoginLogsRepository(new \DateTimeImmutable());

        $entity = $this->makeEntity();

        $created = $repo->create($entity);

        $this->assertSame($entity->id()->toString(), $created->id()->toString());
        $this->assertSame($entity->loginId()->toString(), $created->loginId()->toString());

        $read = $repo->read($entity->id());
        $this->assertSame($created->id()->toString(), $read->id()->toString());
        $this->assertSame($created->loginResult()->toString(), $read->loginResult()->toString());
    }

    public function test_search_and_filters()
    {
        $repo = new LoginLogsRepository(new \DateTimeImmutable());

        // create mixed records
        $e1 = $this->makeEntity(['login_id' => 'alice', 'login_result' => Vo\LoginResult::SUCCESS]);
        $e2 = $this->makeEntity(['login_id' => 'bob', 'login_result' => Vo\LoginResult::FAILURE]);
        $e3 = $this->makeEntity(['login_id' => 'carol', 'login_result' => Vo\LoginResult::SUCCESS, 'ip_address' => '10.0.0.5']);

        $repo->create($e1);
        $repo->create($e2);
        $repo->create($e3);

        // search for SUCCESS results
        $cond = new \App\Domain\Log\LoginLogs\SearchCondition(
            [new Vo\LoginActorType(Vo\LoginActorType::ADMIN)],
            new Vo\AccountId(null),
            new Vo\ImpersonatorAccountId(null),
            [new Vo\LoginResult(Vo\LoginResult::SUCCESS)],
            [],
            new Vo\LoggedInAt(null),
            new Vo\LoggedInAt(null),
            new SearchKeyword(null),
        );

        $results = $repo->search($cond);
        $this->assertCount(2, $results);

        // keyword search by ip
        $cond2 = new \App\Domain\Log\LoginLogs\SearchCondition(
            [],
            new Vo\AccountId(null),
            new Vo\ImpersonatorAccountId(null),
            [],
            [],
            new Vo\LoggedInAt(null),
            new Vo\LoggedInAt(null),
            new SearchKeyword('10.0.0.5'),
        );

        $r2 = $repo->search($cond2);
        $this->assertCount(1, $r2);
        $this->assertSame('carol', $r2[0]->loginId()->toString());
    }

    public function test_check_failure_login_limit()
    {
        // set small threshold to test quickly
        $this->app['config']->set('auth.login_failure_threshold', 3);
        $this->app['config']->set('auth.login_failure_minutes', 15);

        $repo = new LoginLogsRepository(new \DateTimeImmutable());

        $loginId = 'attacker';

        // create 3 failures within timeframe
        for ($i = 0; $i < 3; $i++) {
            $e = $this->makeEntity(['login_id' => $loginId, 'login_result' => Vo\LoginResult::FAILURE, 'logged_in_at' => now()->format('Y-m-d\TH:i:s')]);
            $repo->create($e);
        }

        $allowed = $repo->checkFailureLoginLimit(new Vo\LoginId($loginId));
        $this->assertFalse($allowed, 'Expected login to be blocked when failures reach threshold');

        // cleanup and insert only 2 failures
        \DB::table('login_logs')->delete();
        for ($i = 0; $i < 2; $i++) {
            $e = $this->makeEntity(['login_id' => $loginId, 'login_result' => Vo\LoginResult::FAILURE, 'logged_in_at' => now()->format('Y-m-d\TH:i:s')]);
            $repo->create($e);
        }

        $allowed2 = $repo->checkFailureLoginLimit(new Vo\LoginId($loginId));
        $this->assertTrue($allowed2, 'Expected login to be allowed when failures below threshold');
    }
}
