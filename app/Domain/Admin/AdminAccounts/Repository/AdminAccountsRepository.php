<?php
declare(strict_types=1);

namespace App\Domain\Admin\AdminAccounts\Repository;

use App\Domain\Admin\AdminAccounts\Entity\AdminAccount;
use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Domain\Admin\AdminAccounts\ValueObject as Vo;
use App\Domain\Shared\ValueObject as Svo;
use DateTimeInterface;

interface AdminAccountsRepository
{
    /**
     * @param \DateTimeInterface $datetime
     */
    public function __construct(DateTimeInterface $datetime);

    /**
     * @param \App\Domain\Admin\AdminAccounts\SearchCondition $condition
     * @return \App\Domain\Admin\AdminAccounts\Entity\AdminAccount[]
     */
    public function search(SearchCondition $condition): array;

    /**
     * @param \App\Domain\Admin\AdminAccounts\Entity\AdminAccount $entity
     * @return \App\Domain\Admin\AdminAccounts\Entity\AdminAccount
     */
    public function create(AdminAccount $entity): AdminAccount;

    /**
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\Id $id
     * @param ?\App\Domain\Shared\ValueObject\ModifiedAt $modifiedAt
     * @return \App\Domain\Admin\AdminAccounts\Entity\AdminAccount
     */
    public function read(Vo\Id $id, ?Svo\ModifiedAt $modifiedAt = null): AdminAccount;

    /**
     * @param \App\Domain\Admin\AdminAccounts\Entity\AdminAccount $entity
     * @return \App\Domain\Admin\AdminAccounts\Entity\AdminAccount
     */
    public function update(AdminAccount $entity): AdminAccount;

    /**
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\Id $id
     * @return \App\Domain\Admin\AdminAccounts\Entity\AdminAccount
     */
    public function delete(Vo\Id $id): AdminAccount;

    /**
     * @param \App\Domain\Admin\AdminAccounts\ValueObject\Email $email
     * @return ?\App\Domain\Admin\AdminAccounts\Entity\AdminAccount
     */
    public function findByEmail(Vo\Email $email): ?AdminAccount;

    /**
     * @return \App\Domain\Admin\AdminAccounts\Entity\AccountStatusMaster[]
     */
    public function getAccountStatusOptions(): array;
}
