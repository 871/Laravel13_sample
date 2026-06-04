<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\Email;
use DomainException;
use PHPUnit\Framework\TestCase;

final class EmailTest extends TestCase
{
    public function testValidEmail(): void
    {
        $vo = new Email('user@example.com');
        $this->assertSame('user@example.com', $vo->toString());
    }

    public function testNullAllowed(): void
    {
        $vo = new Email(null);
        $this->assertNull($vo->toStringOrNull());
    }

    public function testInvalidFormatThrows(): void
    {
        $this->expectException(DomainException::class);
        new Email('not-an-email');
    }
}
