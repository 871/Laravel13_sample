<?php
declare(strict_types=1);

namespace App\Application\Controller\Shared\Process\Process\Fields;

use ArrayIterator;
use DomainException;
use IteratorAggregate;
use JsonSerializable;
use Illuminate\Support\Arr;

/**
 * @implements \IteratorAggregate<string, mixed>
 */
final class ProcessParams implements IteratorAggregate, JsonSerializable
{
    /**
     * @param array<int|string, mixed> $values
     */
    public function __construct(
        private readonly array $values,
    ) {
    }

    /**
     * @param array<int|string, mixed> $overrides
     * @return self
     */
    public function with(array $overrides = []): self
    {
        // 存在しないキーが指定された場合は例外
        if (array_diff_key($overrides, $this->values) !== []) {
            throw new DomainException(
                'There are no overridable'
                . '[Invalid parameters: ' . print_r(array_diff_key($overrides, $this->values), true) . ' ]'
                . '[allowParamsKeys: ' . print_r(array_keys($this->values), true) . ']',
            );
        }

        return new self(
            array_merge($this->values, $overrides),
        );
    }

    /**
     * @return \ArrayIterator<int|string, mixed>
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->values);
    }

    /**
     * @return array<int|string, mixed>
     */
    public function toArray(): array
    {
        return $this->values;
    }

    /**
     * @return array<int|string, mixed>
     */
    public function jsonSerialize(): array
    {
        return $this->values;
    }

    /**
     * @param string $path
     * @param mixed $value
     * @return self
     */
    public function setParam(string $path, mixed $value): self
    {
        if (!array_key_exists((string)preg_replace('/^([^\.]+)\..+$/', '$1', $path), $this->values)) {
            throw new DomainException(
                'Process Param not fund'
                . '[path: ' . $path . ' ]'
                . '[value: ' . print_r($value, true) . ' ]'
                . '[values: ' . print_r($this->values, true) . ']',
            );
        }

        $ther = clone $this;
        Arr::set($ther->values, $path, $value);

        return $ther;
    }

    /**
     * @param string $path
     * @return mixed
     */
    public function getParam(string $path): mixed
    {
        return Arr::get($this->values, $path)
            ?? throw new DomainException(
                'Process Param not fund'
                . '[path: ' . $path . ' ]'
                . '[values: ' . print_r($this->values, true) . ']',
            );
    }

    /**
     * @param string $path
     * @param mixed $samValue
     * @return bool
     */
    public function hasParam(string $path, mixed $samValue): bool
    {
        return Arr::get($this->values, $path) === $samValue;
    }
}
