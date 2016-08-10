<?php
namespace CurrencyConverter;

/**
 * Value Object Money
 *
 * Class Money
 * @package CurrencyConverter
 */
class Money
{
    /**
     * @var double
     */
    private $value;
    /**
     * @var Currency
     */
    private $currency;

    /**
     * Money constructor.
     * @param double $value
     * @param Currency $currency
     */
    public function __construct($value, Currency $currency)
    {
        $this->value = $value;
        $this->currency = $currency;
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return Money
     */
    public static function __callStatic($name, array $arguments)
    {
        return new self($arguments[0], new Currency($name));
    }

    /**
     * @return double
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return Currency
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param int $decimals
     * @param string $decimalSeparator
     * @param string $thousandSeparator
     * @return string
     */
    public function getFormattedValue($decimals = 2, $decimalSeparator = '.', $thousandSeparator = ',')
    {
        return number_format($this->value, $decimals, $decimalSeparator, $thousandSeparator);
    }
}