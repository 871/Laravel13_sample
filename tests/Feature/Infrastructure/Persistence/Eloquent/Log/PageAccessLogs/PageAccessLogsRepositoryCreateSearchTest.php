<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Persistence\Eloquent\Log\PageAccessLogs;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Infrastructure\Persistence\Eloquent\Log\PageAccessLogs\PageAccessLogsRepository;
use App\Domain\Log\PageAccessLogs\Entity\PageAccessLog as PageAccessLogEntity;
use App\Domain\Log\PageAccessLogs\ValueObject as Vo;
use App\Domain\Shared\ValueObject\CreatedAt as SCreatedAt;

final class PageAccessLogsRepositoryCreateSearchTest extends TestCase
{
    use RefreshDatabase;

    private function makeEntity(array $overrides = []): PageAccessLogEntity
    {
        $id = $overrides['id'] ?? Str::uuid()->toString();
        $accessed = $overrides['accessed'] ?? now()->format('Y-m-d\TH:i:s');
        $accountType = $overrides['account_type'] ?? Vo\AccountType::ADMIN;
        $accountId = array_key_exists('account_id', $overrides) ? $overrides['account_id'] : '900000';
        $method = $overrides['method'] ?? 'GET';
        $path = $overrides['path'] ?? '/';
        $query = array_key_exists('query_string', $overrides) ? $overrides['query_string'] : null;
        $postKeys = array_key_exists('post_keys', $overrides) ? $overrides['post_keys'] : null;
        $route = array_key_exists('route_name', $overrides) ? $overrides['route_name'] : null;
        $referer = array_key_exists('referer', $overrides) ? $overrides['referer'] : null;
        $ip = $overrides['ip_address'] ?? '127.0.0.1';
        $ua = $overrides['user_agent'] ?? 'PHPUnit';
        $created = $overrides['created_at'] ?? now()->format('Y-m-d\TH:i:s');

        return new PageAccessLogEntity(
            new Vo\Id($id),
            Vo\Accessed::fromString($accessed),
            new Vo\AccountType($accountType),
            new Vo\AccountId($accountId !== null ? (string)$accountId : null),
            new Vo\Method($method),
            new Vo\Path($path),
            new Vo\QueryString($query),
            new Vo\PostKeys($postKeys),
            new Vo\RouteName($route),
            new Vo\Referer($referer),
            new Vo\IpAddress($ip),
            new Vo\UserAgent($ua),
            new SCreatedAt($created),
            new Vo\SearchKey(null),
        );
    }

    public function test_create_and_search_by_admin_name_and_keyword()
    {
        // Ensure admin account exists for name-based search
        $adminId = DB::table('admin_accounts')->insertGetId([
            'email' => 'alice.test@example.local',
            'password' => 'x',
            'name' => 'Alice Admin',
            'admin_note' => null,
            'account_status_master_id' => 1,
            'is_email_verified' => 1,
            'password_changed_at' => now()->format('Y-m-d H:i:s'),
            'password_expires_at' => now()->addYear()->format('Y-m-d H:i:s'),
            'created_at' => now()->format('Y-m-d H:i:s'),
            'modified_at' => now()->format('Y-m-d H:i:s'),
        ]);

        $repo = new PageAccessLogsRepository(new \DateTimeImmutable());

        $t1 = now()->subMinutes(10)->format('Y-m-d\TH:i:s');

        $e1 = $this->makeEntity([
            'accessed' => $t1,
            'account_type' => Vo\AccountType::ADMIN,
            'account_id' => $adminId,
            'path' => '/admin/dashboard',
            'route_name' => 'Admin.Dashboard.index',
            'ip_address' => '203.0.113.11',
            'user_agent' => 'UA-Alice',
        ]);

        $created = $repo->create($e1);
        $this->assertSame($e1->id()->toString(), $created->id()->toString());

        // Search by admin name keyword
        $cond = new \App\Domain\Log\PageAccessLogs\SearchCondition(
            Vo\Accessed::fromString(now()->subHour()->format('Y-m-d\TH:i:s')),
            Vo\Accessed::fromString(now()->addHour()->format('Y-m-d\TH:i:s')),
            new Vo\Search\AccountType(Vo\AccountType::ADMIN),
            new Vo\Search\AccountId(null),
            new Vo\Search\Keyword('Alice'),
            new Vo\Search\NavigationType(\App\Domain\Log\PageAccessLogs\ValueObject\Search\NavigationType::FIRST),
            new Vo\SearchKey(null),
            100,
        );

        $results = $repo->search($cond);
        $this->assertCount(1, $results);
        $this->assertSame('/admin/dashboard', $results[0]->path()->toString());
    }

    public function test_search_filters_and_pagination()
    {
        $repo = new PageAccessLogsRepository(new \DateTimeImmutable());

        $t0 = now()->subDays(3)->format('Y-m-d\TH:i:s');
        $t1 = now()->subDays(2)->format('Y-m-d\TH:i:s');
        $t2 = now()->subDay()->format('Y-m-d\TH:i:s');
        $t3 = now()->format('Y-m-d\TH:i:s');

        $a1 = $this->makeEntity(['accessed' => $t0, 'account_type' => Vo\AccountType::ADMIN, 'path' => '/p/0', 'ip_address' => '1.1.1.1']);
        $a2 = $this->makeEntity(['accessed' => $t1, 'account_type' => Vo\AccountType::ADMIN, 'path' => '/p/1', 'ip_address' => '2.2.2.2']);
        $a3 = $this->makeEntity(['accessed' => $t2, 'account_type' => Vo\AccountType::USER, 'path' => '/p/2', 'ip_address' => '3.3.3.3']);
        $a4 = $this->makeEntity(['accessed' => $t3, 'account_type' => Vo\AccountType::ADMIN, 'path' => '/p/3', 'ip_address' => '4.4.4.4']);

        foreach ([$a1, $a2, $a3, $a4] as $e) {
            $repo->create($e);
        }

        // Filter by account_type ADMIN -> should return a1,a2,a4 (3 items)
        $condAdmin = new \App\Domain\Log\PageAccessLogs\SearchCondition(
            Vo\Accessed::fromString(now()->subWeek()->format('Y-m-d\TH:i:s')),
            Vo\Accessed::fromString(now()->addWeek()->format('Y-m-d\TH:i:s')),
            new Vo\Search\AccountType(Vo\AccountType::ADMIN),
            new Vo\Search\AccountId(null),
            new Vo\Search\Keyword(null),
            new Vo\Search\NavigationType(\App\Domain\Log\PageAccessLogs\ValueObject\Search\NavigationType::LAST),
            new Vo\SearchKey(null),
            100,
        );

        $r = $repo->search($condAdmin);
        $this->assertCount(3, $r);

        // Pagination: limit=2, FIRST -> should return earliest two (/p/0, /p/1)
        $condPage = new \App\Domain\Log\PageAccessLogs\SearchCondition(
            Vo\Accessed::fromString(now()->subWeek()->format('Y-m-d\TH:i:s')),
            Vo\Accessed::fromString(now()->addWeek()->format('Y-m-d\TH:i:s')),
            new Vo\Search\AccountType(null),
            new Vo\Search\AccountId(null),
            new Vo\Search\Keyword(null),
            new Vo\Search\NavigationType(\App\Domain\Log\PageAccessLogs\ValueObject\Search\NavigationType::FIRST),
            new Vo\SearchKey(null),
            2,
        );

        $paged = $repo->search($condPage);
        $this->assertCount(2, $paged);
        $this->assertSame('/p/0', $paged[0]->path()->toString());
        $this->assertSame('/p/1', $paged[1]->path()->toString());
    }
}
