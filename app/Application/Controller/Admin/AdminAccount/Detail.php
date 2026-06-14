<?php
declare(strict_types=1);

namespace App\Application\Controller\Admin\AdminAccount;

use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccount as DomainEntity;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Infrastructure\Persistence\Eloquent\Admin\AdminAccounts\AdminAccountsRepository;
use App\Security\Input\StrictCast;

final class Detail implements ApplicationInterface
{
    use ApplicationTrait;

    /**
     * @return \App\Domain\Admin\AdminAccounts\Entity\AdminAccount
     */
    public function getAdminAccount(): DomainEntity
    {
        return (new AdminAccountsRepository($this->datetime))->read(
            new Vo\Id(
                StrictCast::toString($this->request->route('admin_account_id')),
            ),
        );
    }

    /**
     * @return array<\App\Domain\Admin\AdminAccounts\Entity\AdminAccountHistory>
     */
    public function getAdminAccountHistories(): array
    {
        return (new AdminAccountsRepository($this->datetime))->readHistories(
            new Vo\Id(
                StrictCast::toString($this->request->route('admin_account_id')),
            ),
        );
    }
}
