<?php
declare(strict_types=1);

namespace App\Application\Controller\Admin\AdminAccount;

use App\Application\Controller\Admin\AdminAccount as CategoryService;
use App\Application\Controller\Shared\ApplicationInterface;
use App\Application\Controller\Shared\ApplicationTrait;
use App\Domain\Admin\AdminAccounts\SearchCondition;
use App\Domain\Admin\AdminAccounts\ValueObject;
use App\Infrastructure\Persistence\Cake\Admin\AdminAccountsRepository;
use Cake\ORM\Locator\LocatorAwareTrait;
use Cake\ORM\Query\SelectQuery;

final class Search implements ApplicationInterface
{
    use ApplicationTrait;
    use LocatorAwareTrait;

    /**
     * @return array<string, mixed>
     */
    public function getInitParams(): array
    {
        return [];
    }

    /**
     * @return \Cake\ORM\Query\SelectQuery<\App\Model\Entity\Admin\AdminAccount>
     */
    public function getSearchQuery(): SelectQuery
    {
        /** @var array<string, string> $data */
        $data = $this->request->getQuery();

        return (new AdminAccountsRepository($this->datetime))->search(new SearchCondition(
            id: new ValueObject\Id($data['id'] ?? null),
            keyword: ValueObject\Search\Keyword::fromString($data['keyword'] ?? null),
            accountStatusMasterId: new ValueObject\AccountStatusMasterId($data['account_status_master_id'] ?? null),
        ));
    }

    /**
     * @return array<string, array<int|string, string>|int>
     */
    public function getPaginateSettings(): array
    {
        return [
            'limit' => 20,
            'maxLimit' => 200,
            'sortableFields' => [
                'id',
                'email',
                'name',
                'account_status_master_id',
                'is_email_verified',
                'password_changed_at',
                'password_expires_at',
                'created',
                'modified',
            ],
            'order' => [
                'id' => 'DESC',
            ],
        ];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getAccountStatusOptions(): array
    {
        /** @var \App\Application\Controller\Admin\AdminAccount $categoryService */
        $categoryService = $this->createApplication(CategoryService::class);

        return $categoryService->getAccountStatusOptions();
    }
}
