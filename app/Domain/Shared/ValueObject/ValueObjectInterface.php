<?php
declare(strict_types=1);

namespace App\Domain\Shared\ValueObject;

interface ValueObjectInterface
{
    public const ERROR_CODE_EMAIL_FORMAT = 1001;
    public const ERROR_CODE_INTEGER_FORMAT = 1002;
    public const ERROR_CODE_INVALID_FORMAT = 1003;
    public const ERROR_CODE_INVALID_RANGE = 1004;
    public const ERROR_CODE_LENGTH = 1005;
    public const ERROR_CODE_MAX_BYTE_EXCEEDED = 1006;
    public const ERROR_CODE_NOT_EMPTY = 1007;
    public const ERROR_CODE_OUT_OF_TYPE = 1008;
    public const ERROR_CODE_RANGE_EXCEEDED = 1009;
    public const ERROR_CODE_RANGE_OVER = 1010;
    public const ERROR_CODE_RANGE_UNDER = 1011;
    public const ERROR_CODE_TOO_LONG = 1012;
    public const ERROR_CODE_VALUE_PROCESSING = 1013;

}