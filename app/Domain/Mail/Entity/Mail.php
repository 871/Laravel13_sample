<?php
declare(strict_types=1);

namespace App\Domain\Mail\Entity;

use App\Domain\Mail\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;

final class Mail
{
    /**
     * @param \App\Domain\Mail\ValueObject\Id $id
     * @param \App\Domain\Mail\ValueObject\OriginalMessageId $original_message_id
     * @param \App\Domain\Mail\ValueObject\RelatedDataKey $related_data_key
     * @param \App\Domain\Mail\ValueObject\SendStatus $send_status
     * @param \App\Domain\Mail\ValueObject\SendScheduledAt $send_scheduled_at
     * @param \App\Domain\Mail\ValueObject\Title $title
     * @param \App\Domain\Mail\ValueObject\Body $body
     * @param \App\Domain\Mail\ValueObject\MailTo $mail_to
     * @param \App\Domain\Mail\ValueObject\MailCc $mail_cc
     * @param \App\Domain\Mail\ValueObject\MailBcc $mail_bcc
     * @param \App\Domain\Mail\ValueObject\MailReceivedCheck $mail_received_check
     * @param \App\Domain\Mail\ValueObject\MailReturnPath $mail_return_path
     * @param \App\Domain\Shared\ValueObject\Created $created
     * @param \App\Domain\Shared\ValueObject\CreatedBy $created_by
     * @param \App\Domain\Shared\ValueObject\CreatedIp $created_ip
     * @param \App\Domain\Shared\ValueObject\Modified $modified
     * @param \App\Domain\Shared\ValueObject\ModifiedBy $modified_by
     * @param \App\Domain\Shared\ValueObject\ModifiedIp $modified_ip
     * @param array<\App\Domain\Mail\Entity\MailSentLog> $mail_sent_logs
     * @param array<\App\Domain\Mail\Entity\MailReceivedCheckLog> $mail_received_check_logs
     * @param array<\App\Domain\Mail\Entity\MailBounceLog> $mail_bounce_logs
     */
    public function __construct(
        private readonly Vo\Id $id,
        private readonly Vo\OriginalMessageId $original_message_id,
        private readonly Vo\RelatedDataKey $related_data_key,
        private readonly Vo\SendStatus $send_status,
        private readonly Vo\SendScheduledAt $send_scheduled_at,
        private readonly Vo\Title $title,
        private readonly Vo\Body $body,
        private readonly Vo\MailTo $mail_to,
        private readonly Vo\MailCc $mail_cc,
        private readonly Vo\MailBcc $mail_bcc,
        private readonly Vo\MailReceivedCheck $mail_received_check,
        private readonly Vo\MailReturnPath $mail_return_path,
        private readonly SVo\Created $created,
        private readonly SVo\CreatedBy $created_by,
        private readonly SVo\CreatedIp $created_ip,
        private readonly SVo\Modified $modified,
        private readonly SVo\ModifiedBy $modified_by,
        private readonly SVo\ModifiedIp $modified_ip,
        private readonly array $mail_sent_logs = [],
        private readonly array $mail_received_check_logs = [],
        private readonly array $mail_bounce_logs = [],
    ) {
    }

    /**
     * @return \App\Domain\Mail\ValueObject\Id
     */
    public function id(): Vo\Id
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\OriginalMessageId
     */
    public function originalMessageId(): Vo\OriginalMessageId
    {
        return $this->original_message_id;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\RelatedDataKey
     */
    public function relatedDataKey(): Vo\RelatedDataKey
    {
        return $this->related_data_key;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\SendStatus
     */
    public function sendStatus(): Vo\SendStatus
    {
        return $this->send_status;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\SendScheduledAt
     */
    public function sendScheduledAt(): Vo\SendScheduledAt
    {
        return $this->send_scheduled_at;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\Title
     */
    public function title(): Vo\Title
    {
        return $this->title;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\Body
     */
    public function body(): Vo\Body
    {
        return $this->body;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailTo
     */
    public function mailTo(): Vo\MailTo
    {
        return $this->mail_to;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailCc
     */
    public function mailCc(): Vo\MailCc
    {
        return $this->mail_cc;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailBcc
     */
    public function mailBcc(): Vo\MailBcc
    {
        return $this->mail_bcc;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailReceivedCheck
     */
    public function mailReceivedCheck(): Vo\MailReceivedCheck
    {
        return $this->mail_received_check;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailReturnPath
     */
    public function mailReturnPath(): Vo\MailReturnPath
    {
        return $this->mail_return_path;
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

    /**
     * @return \App\Domain\Shared\ValueObject\Modified
     */
    public function modified(): SVo\Modified
    {
        return $this->modified;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\ModifiedBy
     */
    public function modifiedBy(): SVo\ModifiedBy
    {
        return $this->modified_by;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\ModifiedIp
     */
    public function modifiedIp(): SVo\ModifiedIp
    {
        return $this->modified_ip;
    }

    /**
     * @return array<\App\Domain\Mail\Entity\MailSentLog>
     */
    public function mailSentLogs(): array
    {
        return $this->mail_sent_logs;
    }

    /**
     * @return array<\App\Domain\Mail\Entity\MailReceivedCheckLog>
     */
    public function mailReceivedCheckLogs(): array
    {
        return $this->mail_received_check_logs;
    }

    /**
     * @return array<\App\Domain\Mail\Entity\MailBounceLog>
     */
    public function mailBounceLogs(): array
    {
        return $this->mail_bounce_logs;
    }
}
