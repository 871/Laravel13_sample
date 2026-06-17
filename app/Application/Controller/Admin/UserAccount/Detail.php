<?php
declare(strict_types=1);

namespace App\Application\Controller\Admin\UserAccount;

use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use App\Domain\User\UserAccounts\Entity\UserAccount as DomainEntity;
use App\Domain\User\UserAccounts\ValueObject as Vo;
use App\Infrastructure\Persistence\Eloquent\User\UserAccounts\UserAccountsRepository;
use App\Security\Input\StrictCast;

final class Detail implements ApplicationInterface
{
    use ApplicationTrait;

    /**
     * @return \App\Domain\User\UserAccounts\Entity\UserAccount
     */
    public function getUserAccount(): DomainEntity
    {
        return (new UserAccountsRepository($this->datetime))->read(
            new Vo\Id(
                StrictCast::toString($this->request->route('user_account_id')),
            ),
        );
    }

    /**
     * @return array<\App\Domain\User\UserAccounts\Entity\UserAccountHistory>
     */
    public function getUserAccountHistories(): array
    {
        return (new UserAccountsRepository($this->datetime))->readHistories(
            new Vo\Id(
                StrictCast::toString($this->request->route('user_account_id')),
            ),
        );
    }
}
