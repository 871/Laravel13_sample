<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject\Search;

use App\Domain\Admin\AdminAccounts\ValueObject\Search\Keyword;
use PHPUnit\Framework\TestCase;

final class KeywordTest extends TestCase
{
    public function testToQueryLikeOrNull(): void
    {
        $k = new Keyword('abc');
        $this->assertSame('%abc%', $k->toQueryLikeOrNull());

        $k2 = new Keyword(null);
        $this->assertNull($k2->toQueryLikeOrNull());
    }
}
