<?php
declare(strict_types=1);

namespace App\Security\Input;

use DateTimeInterface;
use InvalidArgumentException;

class StrictCast
{
    /**
     * @param mixed $value
     * @return int
     */
    public static function toInt(mixed $value): int
    {
        $result = Cast::toIntOrNull($value);
        if ($result !== null) {
            return $result;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];
        throw new InvalidArgumentException(
            'Invalid integer value: ' . print_r([
                'value' => $value,
                'file' => $caller['file'] ?? null,
                'line' => $caller['line'] ?? null,
                'class' => $caller['class'] ?? null,
                'function' => $caller['function'] ?? null,
            ], true),
        );
    }

    /**
     * @param mixed $value
     * @return float
     */
    public static function toFloat(mixed $value): float
    {
        $result = Cast::toFloatOrNull($value);
        if ($result !== null) {
            return $result;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];
        throw new InvalidArgumentException(
            'Invalid float value: ' . print_r([
                'value' => $value,
                'file' => $caller['file'] ?? null,
                'line' => $caller['line'] ?? null,
                'class' => $caller['class'] ?? null,
                'function' => $caller['function'] ?? null,
            ], true),
        );
    }

    /**
     * @param mixed $value
     * @return string
     */
    public static function toString(mixed $value): string
    {
        $result = Cast::toStringOrNull($value);
        if ($result !== null) {
            return $result;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];
        throw new InvalidArgumentException(
            'Invalid string value: ' . print_r([
                'value' => $value,
                'file' => $caller['file'] ?? null,
                'line' => $caller['line'] ?? null,
                'class' => $caller['class'] ?? null,
                'function' => $caller['function'] ?? null,
            ], true),
        );
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function toBool(mixed $value): bool
    {
        $result = Cast::toBoolOrNull($value);
        if ($result !== null) {
            return $result;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];
        throw new InvalidArgumentException(
            'Invalid boolean value: ' . print_r([
                'value' => $value,
                'file' => $caller['file'] ?? null,
                'line' => $caller['line'] ?? null,
                'class' => $caller['class'] ?? null,
                'function' => $caller['function'] ?? null,
            ], true),
        );
    }

    /**
     * @param mixed $value
     * @return \DateTimeInterface
     */
    public static function toDateTime(mixed $value): DateTimeInterface
    {
        $result = Cast::toDateTimeOrNull($value);
        if ($result !== null) {
            return $result;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];
        throw new InvalidArgumentException(
            'Invalid datetime value: ' . print_r([
                'value' => $value,
                'file' => $caller['file'] ?? null,
                'line' => $caller['line'] ?? null,
                'class' => $caller['class'] ?? null,
                'function' => $caller['function'] ?? null,
            ], true),
        );
    }

    /**
     * @param mixed $value
     * @return \DateTimeInterface
     */
    public static function toDate(mixed $value): DateTimeInterface
    {
        $result = Cast::toDateOrNull($value);
        if ($result !== null) {
            return $result;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];
        throw new InvalidArgumentException(
            'Invalid date value: ' . print_r([
                'value' => $value,
                'file' => $caller['file'] ?? null,
                'line' => $caller['line'] ?? null,
                'class' => $caller['class'] ?? null,
                'function' => $caller['function'] ?? null,
            ], true),
        );
    }

    /**
     * @param mixed $value
     * @return \DateTimeInterface
     */
    public static function toTime(mixed $value): DateTimeInterface
    {
        $result = Cast::toTimeOrNull($value);
        if ($result !== null) {
            return $result;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];
        throw new InvalidArgumentException(
            'Invalid time value: ' . print_r([
                'value' => $value,
                'file' => $caller['file'] ?? null,
                'line' => $caller['line'] ?? null,
                'class' => $caller['class'] ?? null,
                'function' => $caller['function'] ?? null,
            ], true),
        );
    }

    /**
     * @param mixed $value
     * @param string $format
     * @return string
     */
    public static function toDateTimeString(mixed $value, string $format = 'Y-m-d\TH:i:s'): string
    {
        $result = Cast::toDateTimeStringOrNull($value, $format);
        if ($result !== null) {
            return $result;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];
        throw new InvalidArgumentException(
            'Invalid datetime string value: ' . print_r([
                'value' => $value,
                'format' => $format,
                'file' => $caller['file'] ?? null,
                'line' => $caller['line'] ?? null,
                'class' => $caller['class'] ?? null,
                'function' => $caller['function'] ?? null,
            ], true),
        );
    }

    /**
     * @param mixed $value
     * @param string $format
     * @return string
     */
    public static function toDateString(mixed $value, string $format = 'Y-m-d'): string
    {
        $result = Cast::toDateStringOrNull($value, $format);
        if ($result !== null) {
            return $result;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];
        throw new InvalidArgumentException(
            'Invalid date string value: ' . print_r([
                'value' => $value,
                'format' => $format,
                'file' => $caller['file'] ?? null,
                'line' => $caller['line'] ?? null,
                'class' => $caller['class'] ?? null,
                'function' => $caller['function'] ?? null,
            ], true),
        );
    }

    /**
     * @param mixed $value
     * @param string $format
     * @return string
     */
    public static function toTimeString(mixed $value, string $format = 'H:i:s'): string
    {
        $result = Cast::toTimeStringOrNull($value, $format);
        if ($result !== null) {
            return $result;
        }

        $trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
        $caller = $trace[1] ?? [];
        throw new InvalidArgumentException(
            'Invalid time string value: ' . print_r([
                'value' => $value,
                'format' => $format,
                'file' => $caller['file'] ?? null,
                'line' => $caller['line'] ?? null,
                'class' => $caller['class'] ?? null,
                'function' => $caller['function'] ?? null,
            ], true),
        );
    }
}
