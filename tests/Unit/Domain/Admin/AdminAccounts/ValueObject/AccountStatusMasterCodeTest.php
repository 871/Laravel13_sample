<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\AccountStatusMasterCode;
use DomainException;
use PHPUnit\Framework\TestCase;

final class AccountStatusMasterCodeTest extends TestCase
{
    public function testValidCodes(): void
    {
        $c = new AccountStatusMasterCode(AccountStatusMasterCode::ACTIVE);
        $this->assertSame(AccountStatusMasterCode::ACTIVE, $c->toString());
    }

    public function testInvalidThrows(): void
    {
        $this->expectException(DomainException::class);
        new AccountStatusMasterCode('UNKNOWN');
    }
}
