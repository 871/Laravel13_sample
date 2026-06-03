<?php
declare(strict_types=1);

namespace App\Domain\Mail;

class SearchCondition
{
    public const DEFAULT_LIMIT = 100;

    /**
     * @param \App\Domain\Mail\ValueObject\SendScheduledAt $sendScheduledAtFrom
     * @param \App\Domain\Mail\ValueObject\SendScheduledAt $sendScheduledAtTo
     * @param \App\Domain\Mail\ValueObject\SendStatus|null $sendStatus
     * @param \App\Domain\Mail\ValueObject\RelatedDataKey $relatedDataKey
     * @param \App\Domain\Mail\ValueObject\Search\NavigationType $navigationType
     * @param \App\Domain\Mail\ValueObject\Search\SearchKey $searchKey
     * @param int $limit
     * @param \App\Domain\Mail\ValueObject\Search\Keyword|null $keyword
     */
    public function __construct(
        private readonly ValueObject\SendScheduledAt $sendScheduledAtFrom,
        private readonly ValueObject\SendScheduledAt $sendScheduledAtTo,
        private readonly ?ValueObject\SendStatus $sendStatus,
        private readonly ValueObject\RelatedDataKey $relatedDataKey,
        private readonly ValueObject\Search\NavigationType $navigationType,
        private readonly ValueObject\Search\SearchKey $searchKey,
        private readonly int $limit = self::DEFAULT_LIMIT,
        private readonly ?ValueObject\Search\Keyword $keyword = null,
    ) {
        // 処理なし
    }

    /**
     * @return \App\Domain\Mail\ValueObject\SendScheduledAt
     */
    public function getSendScheduledAtFrom(): ValueObject\SendScheduledAt
    {
        return $this->sendScheduledAtFrom;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\SendScheduledAt
     */
    public function getSendScheduledAtTo(): ValueObject\SendScheduledAt
    {
        return $this->sendScheduledAtTo;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\SendStatus|null
     */
    public function getSendStatus(): ?ValueObject\SendStatus
    {
        return $this->sendStatus;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\RelatedDataKey
     */
    public function getRelatedDataKey(): ValueObject\RelatedDataKey
    {
        return $this->relatedDataKey;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\Search\NavigationType
     */
    public function getNavigationType(): ValueObject\Search\NavigationType
    {
        return $this->navigationType;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\Search\SearchKey
     */
    public function getSearchKey(): ValueObject\Search\SearchKey
    {
        return $this->searchKey;
    }

    /**
     * @return int
     */
    public function getLimit(): int
    {
        return $this->limit;
    }

    /**
     * @return \App\Domain\Mail\ValueObject\Search\Keyword|null
     */
    public function getKeyword(): ?ValueObject\Search\Keyword
    {
        return $this->keyword;
    }
}
