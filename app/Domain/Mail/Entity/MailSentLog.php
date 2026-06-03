<?php
declare(strict_types=1);

namespace App\Domain\Mail\Entity;

use App\Domain\Mail\ValueObject\MailSentLogs as Vo;
use App\Domain\Shared\ValueObject as SVo;

final class MailSentLog
{
    /**
     * @param \App\Domain\Mail\ValueObject\MailSentLogs\Id $id
     * @param \App\Domain\Mail\ValueObject\MailSentLogs\MailId $mail_id
     * @param \App\Domain\Mail\ValueObject\MailSentLogs\OriginalMessageId $original_message_id
     * @param \App\Domain\Mail\ValueObject\MailSentLogs\SendStatus $send_status
     * @param \App\Domain\Mail\ValueObject\MailSentLogs\ErrorMessage $error_message
     * @param \App\Domain\Mail\ValueObject\MailSentLogs\SentAt $sent_at
     * @param \App\Domain\Shared\ValueObject\Created $created
     * @param \App\Domain\Shared\ValueObject\CreatedBy $created_by
     * @param \App\Domain\Shared\ValueObject\CreatedIp $created_ip
     */
    public function __construct(
        private readonly Vo\Id $id,
        private readonly Vo\MailId $mail_id,
        private readonly Vo\OriginalMessageId $original_message_id,
        private readonly Vo\SendStatus $send_status,
        private readonly Vo\ErrorMessage $error_message,
        private readonly Vo\SentAt $sent_at,
        private readonly SVo\Created $created,
        private readonly SVo\CreatedBy $created_by,
        private readonly SVo\CreatedIp $created_ip,
    ) {
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailSentLogs\Id
     */
    public function id(): Vo\Id
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailSentLogs\MailId
     */
    public function mailId(): Vo\MailId
    {
        return $this->mail_id;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailSentLogs\OriginalMessageId
     */
    public function originalMessageId(): Vo\OriginalMessageId
    {
        return $this->original_message_id;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailSentLogs\SendStatus
     */
    public function sendStatus(): Vo\SendStatus
    {
        return $this->send_status;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailSentLogs\ErrorMessage
     */
    public function errorMessage(): Vo\ErrorMessage
    {
        return $this->error_message;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailSentLogs\SentAt
     */
    public function sentAt(): Vo\SentAt
    {
        return $this->sent_at;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\Created
     */
    public function created(): SVo\Created
    {
        return $this->created;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\CreatedBy
     */
    public function createdBy(): SVo\CreatedBy
    {
        return $this->created_by;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\CreatedIp
     */
    public function createdIp(): SVo\CreatedIp
    {
        return $this->created_ip;
    }
}
