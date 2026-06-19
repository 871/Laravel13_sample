<?php
declare(strict_types=1);

namespace App\Domain\Log\LoginLogs\ValueObject;

use App\Domain\Shared\ValueObject\Trait\StringTrait;
use DomainException;
use Stringable;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class FailureReasonCode implements Stringable, ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_INVALID_VALUE = 1014;


    use StringTrait;

    public const LOGIN_ID_NOT_FOUND = 'LOGIN_ID_NOT_FOUND'; // ログインIDなし
    public const INVALID_PASSWORD = 'INVALID_PASSWORD'; // パスワード不一致
    public const PASSWORD_EXPIRED = 'PASSWORD_EXPIRED'; // パスワード有効期限切れ
    public const LOGIN_FAIL_COUNT_OVER = 'LOGIN_FAIL_COUNT_OVER'; // ログイン失敗回数超過
    public const ACCOUNT_LOCKED = 'ACCOUNT_LOCKED'; // アカウント一時停止中
    public const ACCOUNT_SUSPENDED = 'ACCOUNT_SUSPENDED'; // アカウント永久停止中
    public const ACCOUNT_DELETED = 'ACCOUNT_DELETED'; // アカウント削除済
    public const AUTHENTICATION_FAILED = 'AUTHENTICATION_FAILED'; // その他認証失敗

    public const VALUES = [
        self::LOGIN_ID_NOT_FOUND,
        self::INVALID_PASSWORD,
        self::PASSWORD_EXPIRED,
        self::LOGIN_FAIL_COUNT_OVER,
        self::ACCOUNT_LOCKED,
        self::ACCOUNT_SUSPENDED,
        self::ACCOUNT_DELETED,
        self::AUTHENTICATION_FAILED,
    ];

    /**
     * @param ?string $value
     */
    public function __construct(
        private readonly ?string $value,
    ) {
        if ($value !== null && !in_array($value, self::VALUES, true)) {
            throw new DomainException(
                self::class . ' value invalid Error'
                . '[value: ' . mb_strimwidth($value, 0, 200, '...') . ']',
                self::ERROR_CODE_INVALID_VALUE,
            );
        }
    }
}
