<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\Id;
use DomainException;
use PHPUnit\Framework\TestCase;

final class IdTest extends TestCase
{
    public function testValidId(): void
    {
        $vo = new Id('900000');
        $this->assertSame('900000', $vo->toString());
        $this->assertSame(900000, $vo->toInt());
    }

    public function testNullAllowed(): void
    {
        $vo = new Id(null);
        $this->assertNull($vo->toStringOrNull());
        $this->assertNull($vo->toIntOrNull());
    }

    public function testInvalidFormatThrows(): void
    {
        $this->expectException(DomainException::class);

        new Id('abc');
    }

    public function testOutOfRangeThrows(): void
    {
        $this->expectException(DomainException::class);

        new Id('100');
    }
}
