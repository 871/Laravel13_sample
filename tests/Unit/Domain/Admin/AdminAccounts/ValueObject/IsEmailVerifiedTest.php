<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\IsEmailVerified;
use DomainException;
use PHPUnit\Framework\TestCase;

final class IsEmailVerifiedTest extends TestCase
{
    public function testValidValues(): void
    {
        $v0 = new IsEmailVerified('0');
        $this->assertSame(0, $v0->toInt());

        $v1 = new IsEmailVerified('1');
        $this->assertSame(1, $v1->toInt());

        $vnull = new IsEmailVerified(null);
        $this->assertNull($vnull->toIntOrNull());
    }

    public function testInvalidThrows(): void
    {
        $this->expectException(DomainException::class);
        new IsEmailVerified('2');
    }
}
