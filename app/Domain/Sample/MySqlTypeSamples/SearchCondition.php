<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples;

class SearchCondition
{
    /**
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\Id $id
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\IntCol $intColFrom
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\IntCol $intColTo
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\BigintCol $bigintColFrom
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\BigintCol $bigintColTo
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DecimalCol $decimalColFrom
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DecimalCol $decimalColTo
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\FloatCol $floatColFrom
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\FloatCol $floatColTo
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DoubleCol $doubleColFrom
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DoubleCol $doubleColTo
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateCol $dateColFrom
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateCol $dateColTo
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\TimeCol $timeColFrom
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\TimeCol $timeColTo
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateTimeCol $datetimeColFrom
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateTimeCol $datetimeColTo
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\Search\Keyword $keyword,
     */
    public function __construct(
        private readonly ValueObject\Id $id,
        private readonly ValueObject\IntCol $intColFrom,
        private readonly ValueObject\IntCol $intColTo,
        private readonly ValueObject\BigintCol $bigintColFrom,
        private readonly ValueObject\BigintCol $bigintColTo,
        private readonly ValueObject\DecimalCol $decimalColFrom,
        private readonly ValueObject\DecimalCol $decimalColTo,
        private readonly ValueObject\FloatCol $floatColFrom,
        private readonly ValueObject\FloatCol $floatColTo,
        private readonly ValueObject\DoubleCol $doubleColFrom,
        private readonly ValueObject\DoubleCol $doubleColTo,
        private readonly ValueObject\DateCol $dateColFrom,
        private readonly ValueObject\DateCol $dateColTo,
        private readonly ValueObject\TimeCol $timeColFrom,
        private readonly ValueObject\TimeCol $timeColTo,
        private readonly ValueObject\DateTimeCol $datetimeColFrom,
        private readonly ValueObject\DateTimeCol $datetimeColTo,
        private readonly ValueObject\Search\Keyword $keyword,
    ) {
        // 処理なし
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\Id
     */
    public function getId(): ValueObject\Id
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\IntCol
     */
    public function getIntColFrom(): ValueObject\IntCol
    {
        return $this->intColFrom;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\IntCol
     */
    public function getIntColTo(): ValueObject\IntCol
    {
        return $this->intColTo;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\BigintCol
     */
    public function getBigintColFrom(): ValueObject\BigintCol
    {
        return $this->bigintColFrom;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\BigintCol
     */
    public function getBigintColTo(): ValueObject\BigintCol
    {
        return $this->bigintColTo;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DecimalCol
     */
    public function getDecimalColFrom(): ValueObject\DecimalCol
    {
        return $this->decimalColFrom;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DecimalCol
     */
    public function getDecimalColTo(): ValueObject\DecimalCol
    {
        return $this->decimalColTo;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\FloatCol
     */
    public function getFloatColFrom(): ValueObject\FloatCol
    {
        return $this->floatColFrom;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\FloatCol
     */
    public function getFloatColTo(): ValueObject\FloatCol
    {
        return $this->floatColTo;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DoubleCol
     */
    public function getDoubleColFrom(): ValueObject\DoubleCol
    {
        return $this->doubleColFrom;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DoubleCol
     */
    public function getDoubleColTo(): ValueObject\DoubleCol
    {
        return $this->doubleColTo;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateCol
     */
    public function getDateColFrom(): ValueObject\DateCol
    {
        return $this->dateColFrom;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateCol
     */
    public function getDateColTo(): ValueObject\DateCol
    {
        return $this->dateColTo;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\TimeCol
     */
    public function getTimeColFrom(): ValueObject\TimeCol
    {
        return $this->timeColFrom;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\TimeCol
     */
    public function getTimeColTo(): ValueObject\TimeCol
    {
        return $this->timeColTo;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateTimeCol
     */
    public function getDatetimeColFrom(): ValueObject\DateTimeCol
    {
        return $this->datetimeColFrom;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateTimeCol
     */
    public function getDatetimeColTo(): ValueObject\DateTimeCol
    {
        return $this->datetimeColTo;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\Search\Keyword
     */
    public function getKeyword(): ValueObject\Search\Keyword
    {
        return $this->keyword;
    }
}
