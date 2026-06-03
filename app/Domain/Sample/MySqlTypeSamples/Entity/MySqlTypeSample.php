<?php
declare(strict_types=1);

namespace App\Domain\Sample\MySqlTypeSamples\Entity;

use App\Domain\Sample\MySqlTypeSamples\ValueObject;

final class MySqlTypeSample
{
    /**
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\Id $id
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\IntCol $int_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\BigintCol $bigint_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DecimalCol $decimal_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\FloatCol $float_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DoubleCol $double_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateCol $date_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\TimeCol $time_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateTimeCol $datetime_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\CharCol $char_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\VarcharCol $varchar_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\TextCol $text_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\MediumtextCol $mediumtext_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\LongtextCol $longtext_col
     * @param \App\Domain\Sample\MySqlTypeSamples\ValueObject\JsonCol $json_col
     */
    public function __construct(
        private readonly ValueObject\Id $id,
        private readonly ValueObject\IntCol $int_col,
        private readonly ValueObject\BigintCol $bigint_col,
        private readonly ValueObject\DecimalCol $decimal_col,
        private readonly ValueObject\FloatCol $float_col,
        private readonly ValueObject\DoubleCol $double_col,
        private readonly ValueObject\DateCol $date_col,
        private readonly ValueObject\TimeCol $time_col,
        private readonly ValueObject\DateTimeCol $datetime_col,
        private readonly ValueObject\CharCol $char_col,
        private readonly ValueObject\VarcharCol $varchar_col,
        private readonly ValueObject\TextCol $text_col,
        private readonly ValueObject\MediumtextCol $mediumtext_col,
        private readonly ValueObject\LongtextCol $longtext_col,
        private readonly ValueObject\JsonCol $json_col,
    ) {
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\Id
     */
    public function id(): ValueObject\Id
    {
        return $this->id;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\IntCol
     */
    public function intCol(): ValueObject\IntCol
    {
        return $this->int_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\BigintCol
     */
    public function bigintCol(): ValueObject\BigintCol
    {
        return $this->bigint_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DecimalCol
     */
    public function decimalCol(): ValueObject\DecimalCol
    {
        return $this->decimal_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\FloatCol
     */
    public function floatCol(): ValueObject\FloatCol
    {
        return $this->float_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DoubleCol
     */
    public function doubleCol(): ValueObject\DoubleCol
    {
        return $this->double_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateCol
     */
    public function dateCol(): ValueObject\DateCol
    {
        return $this->date_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\TimeCol
     */
    public function timeCol(): ValueObject\TimeCol
    {
        return $this->time_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\DateTimeCol
     */
    public function datetimeCol(): ValueObject\DateTimeCol
    {
        return $this->datetime_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\CharCol
     */
    public function charCol(): ValueObject\CharCol
    {
        return $this->char_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\VarcharCol
     */
    public function varcharCol(): ValueObject\VarcharCol
    {
        return $this->varchar_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\TextCol
     */
    public function textCol(): ValueObject\TextCol
    {
        return $this->text_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\MediumtextCol
     */
    public function mediumtextCol(): ValueObject\MediumtextCol
    {
        return $this->mediumtext_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\LongtextCol
     */
    public function longtextCol(): ValueObject\LongtextCol
    {
        return $this->longtext_col;
    }

    /**
     * @return \App\Domain\Sample\MySqlTypeSamples\ValueObject\JsonCol
     */
    public function jsonCol(): ValueObject\JsonCol
    {
        return $this->json_col;
    }
}
