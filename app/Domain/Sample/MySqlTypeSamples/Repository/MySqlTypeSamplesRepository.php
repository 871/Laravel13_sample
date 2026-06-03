<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\Repository;

use App\Domain\Sample\MySqlTypeSamples\Entity\MySqlTypeSample;
use App\Domain\Sample\MySqlTypeSamples\SearchCondition;
use App\Domain\Sample\MySqlTypeSamples\ValueObject as Vo;

interface MySqlTypeSamplesRepository
{
    /**
     * 
     * @return \App\Domain\Sample\MySqlTypeSamples\Entity\MySqlTypeSample[]
     */
    public function search(SearchCondition $condition): array;

    /**
     * 作成
     *
     * @param \App\Domain\Sample\MySqlTypeSamples\Entity\MySqlTypeSample $entity
     * @return \App\Domain\Sample\MySqlTypeSamples\Entity\MySqlTypeSample
     */
    public function create(MySqlTypeSample $entity): MySqlTypeSample;

    /**
     * 取得
     *
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\Id $id
     * @return \App\Domain\Sample\MySqlTypeSamples\Entity\MySqlTypeSample
     */
    public function read(Vo\Id $id): MySqlTypeSample;

    /**
     * 更新
     *
     * @param \App\Domain\Sample\MySqlTypeSamples\Entity\MySqlTypeSample $entity
     * @return \App\Domain\Sample\MySqlTypeSamples\Entity\MySqlTypeSample
     */
    public function update(MySqlTypeSample $entity): MySqlTypeSample;

    /**
     * 削除
     *
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\Id $id
     * @return \App\Domain\Sample\MySqlTypeSamples\Entity\MySqlTypeSample
     */
    public function delete(Vo\Id $id): MySqlTypeSample;
}
