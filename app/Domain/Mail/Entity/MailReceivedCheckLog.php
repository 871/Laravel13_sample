<?php
declare(strict_types=1);

namespace App\Domain\Mail\Entity;

use App\Domain\Mail\ValueObject\MailReceivedCheckLogs as Vo;
use App\Domain\Shared\ValueObject as SVo;

final class MailReceivedCheckLog
{
    /**
     * @param \App\Domain\Mail\ValueObject\MailReceivedCheckLogs\Id $id
     * @param \App\Domain\Mail\ValueObject\MailReceivedCheckLogs\MailId $mail_id
     * @param \App\Domain\Mail\ValueObject\MailReceivedCheckLogs\OriginalMessageId $original_message_id
     * @param \App\Domain\Mail\ValueObject\MailReceivedCheckLogs\CheckedAddress $checked_address
     * @param \App\Domain\Mail\ValueObject\MailReceivedCheckLogs\CheckedAt $checked_at
     * @param \App\Domain\Shared\ValueObject\Created $created
     * @param \App\Domain\Shared\ValueObject\CreatedBy $created_by
     * @param \App\Domain\Shared\ValueObject\CreatedIp $created_ip
     */
    public function __construct(
        private readonly Vo\Id $id,
        private readonly Vo\MailId $mail_id,
        private readonly Vo\OriginalMessageId $original_message_id,
        private readonly Vo\CheckedAddress $checked_address,
        private readonly Vo\CheckedAt $checked_at,
        private readonly SVo\Created $created,
        private readonly SVo\CreatedBy $created_by,
        private readonly SVo\CreatedIp $created_ip,
    ) {
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailReceivedCheckLogs\Id
     */
    public function id(): Vo\Id
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailReceivedCheckLogs\MailId
     */
    public function mailId(): Vo\MailId
    {
        return $this->mail_id;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailReceivedCheckLogs\OriginalMessageId
     */
    public function originalMessageId(): Vo\OriginalMessageId
    {
        return $this->original_message_id;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailReceivedCheckLogs\CheckedAddress
     */
    public function checkedAddress(): Vo\CheckedAddress
    {
        return $this->checked_address;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\MailReceivedCheckLogs\CheckedAt
     */
    public function checkedAt(): Vo\CheckedAt
    {
        return $this->checked_at;
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
