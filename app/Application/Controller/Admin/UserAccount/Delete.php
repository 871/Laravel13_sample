<?php
declare(strict_types=1);

namespace App\Application\Controller\Admin\UserAccount;

use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use App\Domain\User\UserAccounts\Entity\UserAccount;
use App\Domain\User\UserAccounts\ValueObject as Vo;
use App\Infrastructure\Persistence\Eloquent\User\UserAccounts\UserAccountsRepository;
use Illuminate\Support\Facades\DB;
use App\Security\Input\StrictCast;

final class Delete implements ApplicationInterface
{
    use ApplicationTrait;

    /**
     * @return \App\Domain\User\UserAccounts\Entity\UserAccount
     */
    public function delete(): UserAccount
    {
        return DB::transaction(function () {
            return (new UserAccountsRepository($this->datetime))->delete(
                new Vo\Id(
                    StrictCast::toString($this->request->route('user_account_id')),
                ),
            );
        });
    }
}
