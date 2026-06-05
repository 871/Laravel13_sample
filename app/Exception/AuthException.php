<?php
declare(strict_types=1);

namespace App\Exception;

use App\Domain\Log\LoginLogs\ValueObject as Vo;
use Exception;

class AuthException extends Exception
{
    public const LOGIN_ID_NOT_FOUND = Vo\FailureReasonCode::LOGIN_ID_NOT_FOUND; // ログインIDなし
    public const INVALID_PASSWORD = Vo\FailureReasonCode::INVALID_PASSWORD; // パスワード不一致
    public const PASSWORD_EXPIRED = Vo\FailureReasonCode::PASSWORD_EXPIRED; // パスワード有効期限切れ
    public const LOGIN_FAIL_COUNT_OVER = Vo\FailureReasonCode::LOGIN_FAIL_COUNT_OVER; // ログイン失敗回数超過
    public const ACCOUNT_LOCKED = Vo\FailureReasonCode::ACCOUNT_LOCKED; // アカウント一時停止中
    public const ACCOUNT_SUSPENDED = Vo\FailureReasonCode::ACCOUNT_SUSPENDED; // アカウント永久停止中
    public const ACCOUNT_DELETED = Vo\FailureReasonCode::ACCOUNT_DELETED; // アカウント削除済
    public const AUTHENTICATION_FAILED = Vo\FailureReasonCode::AUTHENTICATION_FAILED; // その他認証失敗

    /**
     * @param string $message
     * @param string $failureReasonCode
     */
    public function __construct(
        string $message,
        private readonly string $failureReasonCode,
    ) {
        parent::__construct($message);
    }

    /**
     * ログイン失敗理由コードを取得
     *
     * @return string
     */
    public function getFailureReasonCode(): string
    {
        return $this->failureReasonCode;
    }
}
