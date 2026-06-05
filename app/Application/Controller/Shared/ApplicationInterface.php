<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared;

use App\Security\Auth\AuthContext;
use Illuminate\Http\Request;
use DateTimeInterface;

interface ApplicationInterface
{
    /**
     * @param \DateTimeInterface $datetime
     * @param \Illuminate\Http\Request $request
     * @param \App\Security\Auth\AuthContext $authContext
     */
    public function __construct(
        DateTimeInterface $datetime,
        Request $request,
        AuthContext $authContext,
    );

    /**
     * @param string $className
     * @return self
     */
    public function createApplication(string $className): self;
}
