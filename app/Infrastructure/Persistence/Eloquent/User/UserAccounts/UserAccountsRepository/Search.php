<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\User\UserAccounts\UserAccountsRepository;

use App\Domain\User\UserAccounts\SearchCondition;
use App\Models\User\UserAccount;
use DateTimeInterface;

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
        $userAccountModel = UserAccount::query()
            ->join(
                'account_status_masters', 
                'account_status_masters.id', 
                '=', 
                'user_accounts.account_status_master_id'
            )
            ->select(
                'user_accounts.id',
                'user_accounts.email',
                'user_accounts.password',
                'user_accounts.name',
                'user_accounts.account_status_master_id',
                'account_status_masters.code as account_status_master_code',
                'account_status_masters.name as account_status_master_name',
                'user_accounts.is_email_verified',
                'user_accounts.password_changed_at',
                'user_accounts.password_expires_at',
                'user_accounts.created_at',
                'user_accounts.created_by',
                'user_accounts.created_ip',
                'user_accounts.modified_at',
                'user_accounts.modified_by',
                'user_accounts.modified_ip',
            )
            ->when(
                filled($condition->getId()->toStringOrNull()),
                fn ($q) => $q->where('user_accounts.id', $condition->getId()->toString())
            )
            ->when(
                filled($condition->getAccountStatusMasterId()->toStringOrNull()),
                fn ($q) => $q->where('user_accounts.account_status_master_id', $condition->getAccountStatusMasterId()->toString())
            )
            ->when(
                filled($condition->getKeyword()->toQueryLikeOrNull()),
                function ($q) use ($condition) {
                    $keyword = $condition->getKeyword()->toQueryLikeOrNull();
                    $q->where(function ($q) use ($keyword) {
                        $q->where('user_accounts.name', 'like', $keyword)
                          ->orWhere('user_accounts.email', 'like', $keyword);
                    });
                }
            )
            ->orderBy(
                $condition->getOrderBy()->getColumn(), 
                $condition->getOrderBy()->getOrder(),
            )
            ->orderBy('user_accounts.id', 'DESC')
            ;

        $paginator = $userAccountModel->paginate(
            perPage: $condition->getPerPage(),
            page: $condition->getPage(),
        );

        return $paginator->setCollection(
            $paginator->getCollection()
                ->map(fn ($model) => Mapper::mapModelToDomain($model))
        )->toArray();
    }
}
