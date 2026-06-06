<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Persistence\Eloquent\Log\LoginLogs;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Infrastructure\Persistence\Eloquent\Log\LoginLogs\LoginLogsRepository;
use App\Domain\Log\LoginLogs\Entity\LoginLog as LoginLogEntity;
use App\Domain\Log\LoginLogs\ValueObject as Vo;
use App\Domain\Log\LoginLogs\ValueObject\Search\Keyword as SearchKeyword;
use App\Domain\Log\LoginLogs\SearchCondition;
use App\Domain\Shared\ValueObject\OrderBy;
use App\Domain\Shared\ValueObject\CreatedAt as SCreatedAt;

/**
 * ./vendor/bin/sail artisan test --env=testing --filter=LoginLogsRepositorySearchTest
 */
final class LoginLogsRepositorySearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    protected function tearDown(): void
    {
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
            new SCreatedAt($created),
        );
    }

    public function test_search_filters_and_keyword_and_order_and_pagination()
    {
        $repo = new LoginLogsRepository(new \DateTimeImmutable());

        // Create diverse records
        $t0 = now()->subDays(3)->format('Y-m-d\TH:i:s');
        $t1 = now()->subDays(2)->format('Y-m-d\TH:i:s');
        $t2 = now()->subDay()->format('Y-m-d\TH:i:s');
        $t3 = now()->format('Y-m-d\TH:i:s');

        $e1 = $this->makeEntity(['login_id' => 'alice', 'login_result' => Vo\LoginResult::SUCCESS, 'login_actor_type' => Vo\LoginActorType::ADMIN, 'ip_address' => '1.1.1.1', 'user_agent' => 'UA-alice', 'logged_in_at' => $t1]);
        $e2 = $this->makeEntity(['login_id' => 'bob', 'login_result' => Vo\LoginResult::FAILURE, 'login_actor_type' => Vo\LoginActorType::ADMIN, 'ip_address' => '2.2.2.2', 'user_agent' => 'UA-bob', 'failure_reason_code' => Vo\FailureReasonCode::ACCOUNT_LOCKED, 'logged_in_at' => $t2]);
        $e3 = $this->makeEntity(['login_id' => 'carol', 'login_result' => Vo\LoginResult::SUCCESS, 'login_actor_type' => Vo\LoginActorType::USER, 'ip_address' => '10.0.0.5', 'user_agent' => 'UA-carol', 'logged_in_at' => $t0]);
        $e4 = $this->makeEntity(['login_id' => 'attacker', 'login_result' => Vo\LoginResult::FAILURE, 'login_actor_type' => Vo\LoginActorType::ADMIN, 'ip_address' => '9.9.9.9', 'user_agent' => 'BadAgent', 'failure_reason_code' => Vo\FailureReasonCode::INVALID_PASSWORD, 'logged_in_at' => $t3]);
        $e5 = $this->makeEntity(['login_id' => 'keyword-user', 'login_result' => Vo\LoginResult::SUCCESS, 'login_actor_type' => Vo\LoginActorType::ADMIN, 'ip_address' => '192.0.2.5', 'user_agent' => 'SpecialAgent', 'logged_in_at' => $t2]);

        foreach ([$e1, $e2, $e3, $e4, $e5] as $e) {
            $repo->create($e);
        }

        // 1) Filter by loginResult SUCCESS and actor ADMIN -> e1 and e5
        $cond1 = new SearchCondition([
            new Vo\LoginActorType(Vo\LoginActorType::ADMIN),
        ], new Vo\AccountId(null), new Vo\ImpersonatorAccountId(null), [
            new Vo\LoginResult(Vo\LoginResult::SUCCESS),
        ], [], new Vo\LoggedInAt(null), new Vo\LoggedInAt(null), new SearchKeyword(null));

        $r1 = $repo->search($cond1);
        $this->assertCount(2, $r1);
        $this->assertContainsEquals('alice', array_map(fn($d) => $d->loginId()->toString(), $r1));
        $this->assertContainsEquals('keyword-user', array_map(fn($d) => $d->loginId()->toString(), $r1));

        // 2) Filter by failure reason code LOCKED -> only bob
        $cond2 = new SearchCondition([], new Vo\AccountId(null), new Vo\ImpersonatorAccountId(null), [], [
            new Vo\FailureReasonCode(Vo\FailureReasonCode::ACCOUNT_LOCKED),
        ], new Vo\LoggedInAt(null), new Vo\LoggedInAt(null), new SearchKeyword(null));

        $r2 = $repo->search($cond2);
        $this->assertCount(1, $r2);
        $this->assertSame('bob', $r2[0]->loginId()->toString());

        // 3) Time range: from t1 (inclusive) to t3 -> should include e1 (t1), e2 (t2), e5 (t2), e4 (t3) => 4 results
        $cond3 = new SearchCondition([], new Vo\AccountId(null), new Vo\ImpersonatorAccountId(null), [], [], new Vo\LoggedInAt($t1), new Vo\LoggedInAt($t3), new SearchKeyword(null));
        $r3 = $repo->search($cond3);
        $this->assertCount(4, $r3);
        // default order is logged_in_at DESC, so first should be e4 (t3)
        $this->assertSame('attacker', $r3[0]->loginId()->toString());

        // 4) Keyword search by IP
        $cond4 = new SearchCondition([], new Vo\AccountId(null), new Vo\ImpersonatorAccountId(null), [], [], new Vo\LoggedInAt(null), new Vo\LoggedInAt(null), new SearchKeyword('192.0.2.5'));
        $r4 = $repo->search($cond4);
        $this->assertCount(1, $r4);
        $this->assertSame('keyword-user', $r4[0]->loginId()->toString());

        // 5) Pagination: perPage=2, page=2 -> should return 2 records (items 3-4 of ordered list). Use OrderBy login_logs.logged_in_at DESC
        $order = new OrderBy('login_logs.logged_in_at', OrderBy::DESC);
        $cond5 = new SearchCondition([], new Vo\AccountId(null), new Vo\ImpersonatorAccountId(null), [], [], new Vo\LoggedInAt(null), new Vo\LoggedInAt(null), new SearchKeyword(null), $order, 2, 2);
        $r5 = $repo->search($cond5);
        $this->assertCount(2, $r5);

        // 6) AccountId and impersonator filter -> create a specific entry and ensure found
        $e6 = $this->makeEntity(['login_id' => 'svc', 'account_id' => 555, 'impersonator_account_id' => 999, 'logged_in_at' => $t3]);
        $repo->create($e6);

        $cond6 = new SearchCondition([], new Vo\AccountId('555'), new Vo\ImpersonatorAccountId('999'), [], [], new Vo\LoggedInAt(null), new Vo\LoggedInAt(null), new SearchKeyword(null));
        $r6 = $repo->search($cond6);
        $this->assertCount(1, $r6);
        $this->assertSame('svc', $r6[0]->loginId()->toString());
    }
}
