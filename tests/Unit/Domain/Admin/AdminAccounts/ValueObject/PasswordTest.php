<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\Password;
use DomainException;
use PHPUnit\Framework\TestCase;

final class PasswordTest extends TestCase
{
    public function testValidAndNull(): void
    {
        $vo = new Password('secret');
        $this->assertSame('secret', $vo->toString());

        $nullVo = new Password(null);
        $this->assertNull($nullVo->toStringOrNull());
    }

    public function testTooLongThrows(): void
    {
        $this->expectException(DomainException::class);

        $long = str_repeat('p', Password::MAX_LENGTH + 1);
        new Password($long);
    }
}
