<?php
namespace CurrencyConverter;

/**
 * Class MoneyFormatter
 * @package CurrencyConverter
 */
class MoneyFormatter
{
    /**
     * @var Money
     */
    private $money;
    /**
     * @var bool
     */
    protected $unsigned;
    /**
     * @var int
     */
    protected $unitValue;
    /**
     * @var int
     */
    protected $floatValue;

    /**
     * @param Money $money
     * @return $this
     */
    public function setMoney(Money $money)
    {
        $this->money = $money;
        $this->setParsedValues($money->getValue());
        return $this;
    }

    /**
     * @param string $value
     * @param string $currency
     * @return $this
     */
    public function setValue($value, $currency)
    {
        $convertedValue = $this->convertToFloat($value);
        $this->money = new Money($convertedValue, new Currency($currency));
        $this->setParsedValues($convertedValue);
        return $this;
    }

    /**
     * @param int $decimals
     * @param string $decimalSeparator
     * @param string $thousandSeparator
     * @return string
     */
    public function format($decimals = 2, $decimalSeparator = '.', $thousandSeparator = '')
    {
        return number_format($this->money->getValue(), $decimals, $decimalSeparator, $thousandSeparator);
    }

    /**
     * @param string|int|float $number
     * @return float
     */
    private function convertToFloat($number)
    {
        if (1 == substr_count($number, ',') && strpos($number, ',') > strpos($number, '.')) {
            $number = str_replace(',', '.', preg_replace('/[^\d,-]/', '', $number));
        }
        return (float)filter_var($number, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    }

    /**
     * @param float $value
     */
    private function setParsedValues($value)
    {
        $this->unsigned = (0 < $value);
        list($this->unitValue, $this->floatValue) = explode('.', number_format(abs($value), 2, '.', ''));
    }
}