<?php
declare(strict_types=1);

namespace App\Exception;

use Cake\Utility\Hash;
use Exception;

class ValidateException extends Exception
{
    /**
     * @param array<string, array<string, string|array<int|string, mixed>>> $errorInfos
     */
    public function __construct(
        /** @var array<string, array<string, string|array<int|string, mixed>>> */
        private readonly array $errorInfos,
    ) {
        // 処理なし
    }

    /**
     * @return list<string>
     */
    public function getErrorMessages(): array
    {
        $flatten = Hash::flatten($this->errorInfos);

        /** @var list<string> $strings */
        $strings = array_values(array_filter(
            $flatten,
            fn($v): bool => is_string($v),
        ));

        return array_values(array_unique($strings));
    }

    /**
     * @return array<string>
     */
    public function getErrorFields(): array
    {
        return array_map(fn() => 'is-invalid', $this->errorInfos);
    }
}
