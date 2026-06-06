<?php

declare(strict_types=1);

namespace Tests\Feature\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts\AdminAccountsRepository as Repo;
use App\Models\Admin\AdminAccount;
use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;

final class AdminAccountsRepositorySearchIntegrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // rely on migrations to create account_status_masters (migration seeds some codes)

        // create three admin accounts with different statuses and values
        $now = now()->format('Y-m-d H:i:s');
        AdminAccount::query()->delete();
        
        AdminAccount::create([
            'email' => 'alice@example.com',
            'password' => bcrypt('pass'),
            'name' => 'Alice',
            'admin_note' => null,
            'account_status_master_id' => 200,
            'is_email_verified' => 0,
            'password_changed_at' => $now,
            'password_expires_at' => $now,
            'created_at' => $now,
            'modified_at' => $now,
        ]);

        AdminAccount::create([
            'email' => 'bob@example.com',
            'password' => bcrypt('pass'),
            'name' => 'Bob',
            'admin_note' => null,
            'account_status_master_id' => 810,
            'is_email_verified' => 0,
            'password_changed_at' => $now,
            'password_expires_at' => $now,
            'created_at' => $now,
            'modified_at' => $now,
        ]);

        AdminAccount::create([
            'email' => 'carol@example.com',
            'password' => bcrypt('pass'),
            'name' => 'Carol',
            'admin_note' => null,
            'account_status_master_id' => 200,
            'is_email_verified' => 0,
            'password_changed_at' => $now,
            'password_expires_at' => $now,
            'created_at' => $now,
            'modified_at' => $now,
        ]);
    }

    private function normalizeResult(mixed $result): array
    {
        if (is_array($result)) {
            // paginator->toArray() returns ['data' => [...]]; handle both shapes
            if (array_key_exists('data', $result)) {
                return $result['data'];
            }

            return $result;
        }

        return $result->getCollection()->all();
    }

    public function testFilterByAccountStatusAndIdAffectsResults(): void
    {
        $repo = new Repo(new \DateTimeImmutable());

        // filter by account_status_master_id = 200 (should match Alice and Carol)
        $condition = new SearchCondition(
            new Vo\Id(null),
            new Vo\Search\Keyword(null),
            new Vo\AccountStatusMasterId('200'),
            new SVo\OrderBy('admin_accounts.id', SVo\OrderBy::ASC),
            10,
            1
        );

        $result = $repo->search($condition);
        $collection = $this->normalizeResult($result);

        $this->assertCount(2, $collection);
        $this->assertSame('Alice', $collection[0]->name()->toString());

        // filter by exact id (find Bob only)
        // find Bob's id via DB
        $bobId = DB::table('admin_accounts')->where('email', 'bob@example.com')->value('id');

        $condition2 = new SearchCondition(
            new Vo\Id((string)$bobId),
            new Vo\Search\Keyword(null),
            new Vo\AccountStatusMasterId(null),
            new SVo\OrderBy('admin_accounts.id', SVo\OrderBy::DESC),
            10,
            1
        );

        $res2 = $repo->search($condition2);
        $col2 = $this->normalizeResult($res2);
        $this->assertCount(1, $col2);
        $this->assertSame('Bob', $col2[0]->name()->toString());
    }

    public function testOrderByAndPaginationAffectsResults(): void
    {
        $repo = new Repo(new \DateTimeImmutable());

        // order by id asc, perPage=2 page=1 => first 2
        $cond1 = new SearchCondition(
            new Vo\Id(null),
            new Vo\Search\Keyword(null),
            new Vo\AccountStatusMasterId(null),
            new SVo\OrderBy('admin_accounts.id', SVo\OrderBy::ASC),
            2,
            1
        );

        $r1 = $repo->search($cond1);
        $c1 = $this->normalizeResult($r1);
        $this->assertCount(2, $c1);
        $this->assertSame('Alice', $c1[0]->name()->toString());

        // page 2 should have the third
        $cond2 = new SearchCondition(
            new Vo\Id(null),
            new Vo\Search\Keyword(null),
            new Vo\AccountStatusMasterId(null),
            new SVo\OrderBy('admin_accounts.id', SVo\OrderBy::ASC),
            2,
            2
        );

        $r2 = $repo->search($cond2);
        $c2 = $this->normalizeResult($r2);
        $this->assertCount(1, $c2);
        $this->assertSame('Carol', $c2[0]->name()->toString());
    }

    public function testKeywordSearchAffectsResults(): void
    {
        $repo = new Repo(new \DateTimeImmutable());

        // keyword that matches name 'Alice'
        $condName = new SearchCondition(
            new Vo\Id(null),
            new Vo\Search\Keyword('Ali'),
            new Vo\AccountStatusMasterId(null),
            new SVo\OrderBy('admin_accounts.id', SVo\OrderBy::ASC),
            10,
            1
        );

        $rName = $repo->search($condName);
        $cName = $this->normalizeResult($rName);
        $this->assertCount(1, $cName);
        $this->assertSame('Alice', $cName[0]->name()->toString());

        // keyword that matches email domain (all)
        $condEmail = new SearchCondition(
            new Vo\Id(null),
            new Vo\Search\Keyword('example.com'),
            new Vo\AccountStatusMasterId(null),
            new SVo\OrderBy('admin_accounts.id', SVo\OrderBy::ASC),
            10,
            1
        );

        $rEmail = $repo->search($condEmail);
        $cEmail = $this->normalizeResult($rEmail);
        $this->assertCount(3, $cEmail);
    }
}

