<?php

declare(strict_types=1);

namespace Tests\Unit\Domain\Admin\AdminAccounts\ValueObject;

use App\Domain\Admin\AdminAccounts\ValueObject\AdminNote;
use PHPUnit\Framework\TestCase;

final class AdminNoteTest extends TestCase
{
    public function testToStringAndNull(): void
    {
        $vo = new AdminNote('some note');
        $this->assertSame('some note', $vo->toString());

        $nullVo = new AdminNote(null);
        $this->assertNull($nullVo->toStringOrNull());
    }
}
