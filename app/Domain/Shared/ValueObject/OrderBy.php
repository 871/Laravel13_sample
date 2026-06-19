<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

use DomainException;

use App\Domain\Shared\ValueObject\ValueObjectInterface;

class OrderBy
 implements ValueObjectInterface {
    // TODO: Added error code constants copied from ValueObjectInterface (/Users/hiro871/Develop/laravel-sample/sample-app/app/Domain/Shared/ValueObject/ValueObjectInterface.php)
    public const ERROR_CODE_INVALID_VALUE = 1014;



    const ASC = 'ASC';
    const DESC = 'DESC';
    public const ALLOWED_VALUES = [
        self::ASC,
        self::DESC,
    ];

    /**
     * @param string $column
     * @param string $order
     */
    public function __construct(
        private readonly string $column,
        private readonly string $order = 'ASC',
    ) {
        if (!in_array($order, self::ALLOWED_VALUES, true)) {
            throw new DomainException(
                self::class . ' sort order value not allowed'
                . '[value: ' . mb_strimwidth($order, 0, 200, '...'
            ) . ']'
                . '[allowed: ' . implode(', ', self::ALLOWED_VALUES) . ']',
            self::ERROR_CODE_INVALID_VALUE,
            );
        }
    }

    /**
     * @return string
     */
    public function getColumn(): string
    {
        return $this->column;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }
}
