<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared;

use App\Security\Auth\AuthContext;
use Illuminate\Http\Request;
use DateTimeInterface;
use InvalidArgumentException;

trait ApplicationTrait
{
    /**
     * @param \DateTimeInterface $datetime
     * @param \Illuminate\Http\Request $request
     * @param \App\Security\Auth\AuthContext $authContext
     */
    public function __construct(
        private readonly DateTimeInterface $datetime,
        private readonly Request $request,
        private readonly AuthContext $authContext,
    ) {
        // 処理なし
    }

    /**
     * @param string $className
     * @return \App\Application\Controller\Shared\ApplicationInterface
     */
    public function createApplication(string $className): ApplicationInterface
    {
        return is_subclass_of($className, ApplicationInterface::class)
            ? new $className(
                datetime: $this->datetime,
                request: $this->request,
                authContext: $this->authContext,
            )
            : throw new InvalidArgumentException(
                'ApplicationInterface  must implement ' . ApplicationInterface::class
                . '[className: ' . $className . ']',
            );
    }
}
