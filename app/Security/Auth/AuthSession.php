<?php
declare(strict_types=1);

namespace App\Security\Auth;

use Illuminate\Http\Request;

final class AuthSession
{
    public const PREFIX = 'Auth';

    /**
     * @var string
     */
    private string $sessionKey;

    /**
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(
        private readonly Request $request,
        string $type,
        string $account_id,
    ) {
        $this->sessionKey = join('.', [
            self::PREFIX,
            $type,
            $account_id,
        ]);
    }

    /**
     * @return array<string, string|null>
     */
    public function read(): array
    {
        /** @var array<string, string|null> */
        return $this->request->session()->get($this->sessionKey, []);
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return $this->request->session()->has($this->sessionKey);
    }

    /**
     * @param array<string, string|null> $data
     * @return void
     */
    public function write(array $data): void
    {
        $this->request->session()->put($this->sessionKey, $data);
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        $this->request->session()->forget($this->sessionKey);
    }
}
