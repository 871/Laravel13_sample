<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterId;
use DomainException;
use PHPUnit\Framework\TestCase;

final class AccountStatusMasterIdTest extends TestCase
{
    public function testValidAndNull(): void
    {
        $vo = new AccountStatusMasterId('5');
        $this->assertSame(5, $vo->toInt());

        $nullVo = new AccountStatusMasterId(null);
        $this->assertNull($nullVo->toIntOrNull());
    }

    public function testInvalidThrows(): void
    {
        $this->expectException(DomainException::class);
        new AccountStatusMasterId('abc');
    }
}
