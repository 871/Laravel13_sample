<?php
declare(strict_types=1);

namespace App\Application\Controller\Admin\UserAccount;

use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use App\Domain\User\UserAccounts\SearchCondition;
use App\Domain\User\UserAccounts\ValueObject as Vo;
use App\Infrastructure\Persistence\Eloquent\User\UserAccounts\UserAccountsRepository as EloquentUserAccountsRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class Search implements ApplicationInterface
{
    use ApplicationTrait;

    /**
     * @return array<string, mixed>
     */
    public function getInitParams(): array
    {
        return [];
    }

    /**
     * Build search condition and run Eloquent repository search.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|array
     */
    public function getResults(): LengthAwarePaginator|array
    {
        /** @var array<string, string> $data */
        $data = $this->request->query();

        $condition = new SearchCondition(
            id: new Vo\Id($data['id'] ?? null),
            keyword: Vo\Search\Keyword::fromString($data['keyword'] ?? null),
            accountStatusMasterId: new Vo\AccountStatusMasterId($data['account_status_master_id'] ?? null),
            orderBy: new Vo\Search\OrderBy($data['sort'] ?? 'user_accounts.created_at', $data['direction'] ?? 'DESC'),
            perPage: isset($data['per_page']) ? (int)$data['per_page'] : 20,
            page: isset($data['page']) ? (int)$data['page'] : 1,
        );

        return (new EloquentUserAccountsRepository($this->datetime))->search($condition);
    }

    /**
     * @return array
     */
    public function getAccountStatusOptions(): array
    {
        return (new EloquentUserAccountsRepository($this->datetime))->getAccountStatusOptions();
    }
}
