<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\PasswordExpiresAt;
use DomainException;
use PHPUnit\Framework\TestCase;

final class PasswordExpiresAtTest extends TestCase
{
    public function testValidAndNull(): void
    {
        $vo = new PasswordExpiresAt('2026-06-04T13:00:00');
        $this->assertSame('2026-06-04T13:00:00', $vo->__toString());

        $nullVo = new PasswordExpiresAt(null);
        $this->assertNull($nullVo->__toString() ?: null);
    }

    public function testInvalidFormatThrows(): void
    {
        $this->expectException(DomainException::class);
        new PasswordExpiresAt('2026/06/04 13:00:00');
    }
}
