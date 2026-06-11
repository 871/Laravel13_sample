<?php
declare(strict_types=1);

namespace App\Application\Controller\Admin\AdminAccount;

use App\Application\Controller\Admin\AdminAccount as CategoryService;
use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Domain\Admin\AdminAccounts\ValueObject;
use App\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts\AdminAccountsRepository as EloquentAdminAccountsRepository;
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
    public function getSearchQuery(): LengthAwarePaginator|array
    {
        /** @var array<string, string> $data */
        $data = $this->request->getQuery();

        $condition = new SearchCondition(
            id: new ValueObject\Id($data['id'] ?? null),
            keyword: ValueObject\Search\Keyword::fromString($data['keyword'] ?? null),
            accountStatusMasterId: new ValueObject\AccountStatusMasterId($data['account_status_master_id'] ?? null),
            orderBy: new \App\Domain\Shared\ValueObject\OrderBy($data['order_column'] ?? 'admin_accounts.created_at', $data['order_dir'] ?? 'DESC'),
            perPage: isset($data['per_page']) ? (int)$data['per_page'] : 20,
            page: isset($data['page']) ? (int)$data['page'] : 1,
        );

        return (new EloquentAdminAccountsRepository($this->datetime))->search($condition);
    }

    /**
     * @return array<string, array<int|string, string>|int>
     */
    public function getPaginateSettings(): array
    {
        return [
            'limit' => 20,
            'maxLimit' => 200,
            'sortableFields' => [
                'id',
                'email',
                'name',
                'account_status_master_id',
                'is_email_verified',
                'password_changed_at',
                'password_expires_at',
                'created',
                'modified',
            ],
            'order' => [
                'id' => 'DESC',
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAccountStatusOptions(): array
    {
        /** @var \App\Application\Controller\Admin\AdminAccount $categoryService */
        $categoryService = $this->createApplication(CategoryService::class);

        return $categoryService->getAccountStatusOptions();
    }
}
