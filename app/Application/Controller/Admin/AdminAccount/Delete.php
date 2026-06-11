<?php
declare(strict_types=1);

namespace App\Application\Controller\Admin\AdminAccount;

use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use App\Domain\Admin\AdminAccounts\Entity\AdminAccount;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Infrastructure\Persistence\Cake\Admin\AdminAccountsRepository;
use App\Security\Input\StrictCast;

final class Delete implements ApplicationInterface
{
    use ApplicationTrait;

    /**
     * @return \App\Domain\Admin\AdminAccounts\Entity\AdminAccount
     */
    public function delete(): AdminAccount
    {
        return (new AdminAccountsRepository($this->datetime))->delete(
            new Vo\Id(
                StrictCast::toString($this->request->getParam('admin_account_id')),
            ),
        );
    }
}
