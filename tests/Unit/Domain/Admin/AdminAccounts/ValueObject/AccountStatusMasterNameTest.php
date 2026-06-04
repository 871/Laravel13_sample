<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterName;
use DomainException;
use PHPUnit\Framework\TestCase;

final class AccountStatusMasterNameTest extends TestCase
{
    public function testValidAndNull(): void
    {
        $vo = new AccountStatusMasterName('Active status');
        $this->assertSame('Active status', $vo->toString());

        $nullVo = new AccountStatusMasterName(null);
        $this->assertNull($nullVo->toStringOrNull());
    }

    public function testTooLongThrows(): void
    {
        $this->expectException(DomainException::class);

        $long = str_repeat('a', AccountStatusMasterName::MAX_LENGTH + 1);
        new AccountStatusMasterName($long);
    }
}
