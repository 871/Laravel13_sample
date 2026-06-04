<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Eloquent\Admin\AdminAccountsRepository;

use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Models\Admin\AdminAccount;
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
            ->where(array_filter([
                'id' => $condition->getId()->toStringOrNull(),
                'account_status_master_id' => $condition->getAccountStatusMasterId()->toStringOrNull(),
                'name' => $condition->getKeyword()->toQueryLikeOrNull(),
                'email' => $condition->getKeyword()->toQueryLikeOrNull(),
            ], fn ($v) => !in_array($v, [null, '', []], true)))
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
        );
    }
}
