<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\Name;
use DomainException;
use PHPUnit\Framework\TestCase;

final class NameTest extends TestCase
{
    public function testValidAndNull(): void
    {
        $vo = new Name('Taro');
        $this->assertSame('Taro', $vo->toString());

        $nullVo = new Name(null);
        $this->assertNull($nullVo->toStringOrNull());
    }

    public function testTooLongThrows(): void
    {
        $this->expectException(DomainException::class);
        $long = str_repeat('x', Name::MAX_LENGTH + 1);
        new Name($long);
    }
}
