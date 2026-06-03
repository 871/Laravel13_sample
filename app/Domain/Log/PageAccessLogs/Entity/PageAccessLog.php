<?php
declare(strict_types=1);

namespace App\Domain\Log\PageAccessLogs\Entity;

use App\Domain\Log\PageAccessLogs\ValueObject as Vo;
use App\Domain\Shared\ValueObject as SVo;

final class PageAccessLog
{
    /**
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Id $id
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Accessed $accessed
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\AccountType $account_type
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\AccountId $account_id
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Method $method
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Path $path
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\QueryString $query_string
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\PostKeys $post_keys
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\RouteName $route_name
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\Referer $referer
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\IpAddress $ip_address
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\UserAgent $user_agent
     * @param \App\Domain\Shared\ValueObject\Created $created
     * @param \App\Domain\Log\PageAccessLogs\ValueObject\SearchKey $search_key
     */
    public function __construct(
        private readonly Vo\Id $id,
        private readonly Vo\Accessed $accessed,
        private readonly Vo\AccountType $account_type,
        private readonly Vo\AccountId $account_id,
        private readonly Vo\Method $method,
        private readonly Vo\Path $path,
        private readonly Vo\QueryString $query_string,
        private readonly Vo\PostKeys $post_keys,
        private readonly Vo\RouteName $route_name,
        private readonly Vo\Referer $referer,
        private readonly Vo\IpAddress $ip_address,
        private readonly Vo\UserAgent $user_agent,
        private readonly SVo\Created $created,
        private readonly Vo\SearchKey $search_key,
    ) {
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Id
     */
    public function id(): Vo\Id
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Accessed
     */
    public function accessed(): Vo\Accessed
    {
        return $this->accessed;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\AccountType
     */
    public function accountType(): Vo\AccountType
    {
        return $this->account_type;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\AccountId
     */
    public function accountId(): Vo\AccountId
    {
        return $this->account_id;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Method
     */
    public function method(): Vo\Method
    {
        return $this->method;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Path
     */
    public function path(): Vo\Path
    {
        return $this->path;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\QueryString
     */
    public function queryString(): Vo\QueryString
    {
        return $this->query_string;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\PostKeys
     */
    public function postKeys(): Vo\PostKeys
    {
        return $this->post_keys;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\RouteName
     */
    public function routeName(): Vo\RouteName
    {
        return $this->route_name;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\Referer
     */
    public function referer(): Vo\Referer
    {
        return $this->referer;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\IpAddress
     */
    public function ipAddress(): Vo\IpAddress
    {
        return $this->ip_address;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\UserAgent
     */
    public function userAgent(): Vo\UserAgent
    {
        return $this->user_agent;
    }

    /**
     * @return \App\Domain\Shared\ValueObject\Created
     */
    public function created(): SVo\Created
    {
        return $this->created;
    }

    /**
     * @return \App\Domain\Log\PageAccessLogs\ValueObject\SearchKey
     */
    public function searchKey(): Vo\SearchKey
    {
        return $this->search_key;
    }
}
