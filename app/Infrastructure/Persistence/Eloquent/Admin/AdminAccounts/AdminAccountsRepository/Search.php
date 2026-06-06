<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Models\Admin\AdminAccount;
use DateTimeInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

final class Search
{
    public function __construct(private readonly DateTimeInterface $datetime)
    {
    }

    /**
     * @return array
     */
    public function run(SearchCondition $condition): array
    {
        $adminAccountModel = AdminAccount::query()
            ->join(
                'account_status_masters', 
                'account_status_masters.id', 
                '=', 
                'admin_accounts.account_status_master_id'
            )
            ->select(
                'admin_accounts.id',
                'admin_accounts.email',
                'admin_accounts.password',
                'admin_accounts.name',
                'admin_accounts.admin_note',
                'admin_accounts.account_status_master_id',
                'account_status_masters.code as account_status_master_code',
                'account_status_masters.name as account_status_master_name',
                'admin_accounts.is_email_verified',
                'admin_accounts.password_changed_at',
                'admin_accounts.password_expires_at',
                'admin_accounts.created_at',
                'admin_accounts.created_by',
                'admin_accounts.created_ip',
                'admin_accounts.modified_at',
                'admin_accounts.modified_by',
                'admin_accounts.modified_ip',
            )
            ->when(
                filled($condition->getId()->toStringOrNull()),
                fn ($q) => $q->where('admin_accounts.id', $condition->getId()->toString())
            )
            ->when(
                filled($condition->getAccountStatusMasterId()->toStringOrNull()),
                fn ($q) => $q->where('admin_accounts.account_status_master_id', $condition->getAccountStatusMasterId()->toString())
            )
            ->when(
                filled($condition->getKeyword()->toQueryLikeOrNull()),
                function ($q) use ($condition) {
                    $keyword = $condition->getKeyword()->toQueryLikeOrNull();
                    $q->where(function ($q) use ($keyword) {
                        $q->where('admin_accounts.name', 'like', $keyword)
                          ->orWhere('admin_accounts.email', 'like', $keyword);
                    });
                }
            )
            ->orderBy(
                $condition->getOrderBy()->getColumn(), 
                $condition->getOrderBy()->getOrder(),
            )
            ->orderBy('admin_accounts.id', 'DESC')
            ;

        $paginator = $adminAccountModel->paginate(
            perPage: $condition->getPerPage(),
            page: $condition->getPage(),
        );

        return $paginator->setCollection(
            $paginator->getCollection()
                ->map(fn ($model) => Mapper::mapModelToDomain($model))
        )
        ->toArray();
    }
}
