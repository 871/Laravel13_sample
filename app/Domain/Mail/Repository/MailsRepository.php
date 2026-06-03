<?php
declare(strict_types=1);

namespace App\Domain\Mail\Repository;

use App\Domain\Mail\Entity\Mail;
use App\Domain\Mail\SearchCondition;
use App\Domain\Mail\ValueObject\Id;
use DateTimeImmutable;

interface MailsRepository
{
    /**
     * 作成
     *
     * @param \App\Domain\Mail\Entity\Mail $entity
     * @return \App\Domain\Mail\Entity\Mail
     */
    public function create(Mail $entity): Mail;

    /**
     * 検索
     *
     * @param \App\Domain\Mail\SearchCondition $condition
     * @return array<\App\Domain\Mail\Entity\Mail>
     */
    public function search(SearchCondition $condition): array;

    /**
     * 詳細取得
     *
     * @param \App\Domain\Mail\ValueObject\Id $id
     * @return \App\Domain\Mail\Entity\Mail
     */
    public function read(Id $id): Mail;

    /**
     * 送信待ちメールを送信し、送信ログ保存とステータス更新を行う
     *
     * @param \DateTimeImmutable $now 現在日時
     * @return int 処理件数
     */
    public function sendWaitingMails(DateTimeImmutable $now): int;

    /**
     * 受信確認IMAPサーバを確認し、受信確認ログ保存とステータス更新を行う
     *
     * @param \DateTimeImmutable $now 現在日時
     * @return int 処理件数
     */
    public function checkReceivedMails(DateTimeImmutable $now): int;

    /**
     * バウンスIMAPサーバを確認し、バウンスログ保存とステータス更新を行う
     *
     * @param \DateTimeImmutable $now 現在日時
     * @return int 処理件数
     */
    public function checkBouncedMails(DateTimeImmutable $now): int;
}
