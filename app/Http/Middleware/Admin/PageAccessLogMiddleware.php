<?php
declare(strict_types=1);

namespace App\Http\Middleware\Admin;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Infrastructure\Persistence\Eloquent\Log\PageAccessLogs\PageAccessLogsRepository;
use App\Domain\Log\PageAccessLogs\Entity\PageAccessLog as DomainPageAccessLog;
use App\Domain\Log\PageAccessLogs\ValueObject as Vo;
use App\Domain\Shared\ValueObject\CreatedAt;
use App\Security\Auth\AuthContextResolver;
use Ramsey\Uuid\Uuid;

final class PageAccessLogMiddleware
{
    /**
     * Handle an incoming request and record page access logs for authenticated accounts.
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        try {
            $authContext = AuthContextResolver::resolve($request);
            $type = (string)$authContext->getType();
            $accountIdField = $authContext->getAccountId();

            // account id must be numeric and >= 1
            $accountId = (string)$accountIdField->toString();
            if (!preg_match('/^\d+$/', $accountId) || (int)$accountId < 1) {
                // nothing to log for anonymous/invalid accounts
                return $response;
            }

            $now = new \DateTimeImmutable();

            $id = new Vo\Id(Uuid::uuid7()->toString());
            $accessed = new Vo\Accessed($now->format('Y-m-d\\TH:i:s.u'));
            $account_type = new Vo\AccountType(strtoupper($type));
            $account_id = new Vo\AccountId($accountId);
            $method = new Vo\Method($request->method());
            $path = new Vo\Path($request->getPathInfo() ?: '/');
            $queryString = $request->getQueryString() ?? null;
            $query_string = new Vo\QueryString($queryString ?? '');

            $postKeysArray = array_keys($request->post() ?: []);
            $post_keys = new Vo\PostKeys(empty($postKeysArray) ? '' : implode(',', $postKeysArray));

            $route = $request->route();
            $routeName = null;
            if (is_array($route) && array_key_exists('as', $route)) {
                $routeName = $route['as'] ?? null;
            } elseif (is_object($route) && method_exists($route, 'getName')) {
                $routeName = $route->getName();
            }

            $route_name = new Vo\RouteName($routeName ?? '');
            $referer = new Vo\Referer($request->headers->get('referer') ?? '');
            $ip = new Vo\IpAddress($request->ip() ?? '');
            $ua = new Vo\UserAgent($request->userAgent() ?? '');
            $created_at = new CreatedAt($now->format('Y-m-d\\TH:i:s'));
            $search_key = new Vo\SearchKey(null);

            $entity = new DomainPageAccessLog(
                id: $id,
                accessed: $accessed,
                account_type: $account_type,
                account_id: $account_id,
                method: $method,
                path: $path,
                query_string: $query_string,
                post_keys: $post_keys,
                route_name: $route_name,
                referer: $referer,
                ip_address: $ip,
                user_agent: $ua,
                created_at: $created_at,
                search_key: $search_key,
            );

            (new PageAccessLogsRepository($now))->create($entity);
        } catch (\Throwable $e) {
            // swallow errors so logging doesn't break requests
            Log::error('PageAccessLogMiddleware error', ['exception' => $e]);
        }

        return $response;
    }
}
