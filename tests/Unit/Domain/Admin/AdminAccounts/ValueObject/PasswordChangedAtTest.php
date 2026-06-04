<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\PasswordChangedAt;
use DomainException;
use PHPUnit\Framework\TestCase;

final class PasswordChangedAtTest extends TestCase
{
    public function testValid(): void
    {
        $vo = new PasswordChangedAt('2026-06-03T12:00:00');
        $this->assertSame('2026-06-03T12:00:00', $vo->__toString());
    }

    public function testNullAllowed(): void
    {
        $vo = new PasswordChangedAt(null);
        $this->assertNull($vo->__toString() ?: null);
    }

    public function testInvalidFormatThrows(): void
    {
        $this->expectException(DomainException::class);
        new PasswordChangedAt('2026/06/03 12:00:00');
    }
}
