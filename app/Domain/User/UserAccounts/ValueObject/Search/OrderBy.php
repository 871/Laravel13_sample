<?php
declare(strict_types=1);

namespace App\Domain\User\UserAccounts\ValueObject\Search;

use DomainException;

class OrderBy
{
    const ASC = 'ASC';
    const DESC = 'DESC';
    public const ALLOWED_VALUES = [
        self::ASC,
        self::DESC,
    ];

    private const ALLOWED_COLUMNS = [
        'user_accounts.id',
        'user_accounts.name',
        'user_accounts.email',
        'user_accounts.account_status_master_id',
        'user_accounts.is_email_verified',
        'user_accounts.password_changed_at',
        'user_accounts.created_at',
        'user_accounts.updated_at',
    ];

    /**
     * @param string $column
     * @param string $order
     */
    public function __construct(
        private readonly string $column,
        private readonly string $order = 'ASC',
    ) {
        if (!in_array($order, self::ALLOWED_VALUES, true)) {
            throw new DomainException(
                self::class . ' sort order value not allowed'
                . '[value: ' . mb_strimwidth($order, 0, 200, '...') . ']'
                . '[allowed: ' . implode(', ', self::ALLOWED_VALUES) . ']',
            );
        }

        if (!in_array($column, self::ALLOWED_COLUMNS, true)) {
            throw new DomainException(
                self::class . ' sort column value not allowed'
                . '[value: ' . mb_strimwidth($column, 0, 200, '...') . ']'
                . '[allowed: ' . implode(', ', self::ALLOWED_COLUMNS) . ']',
            );
        }
    }

    /**
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }
}
