<?php
namespace CurrencyConverter\Money;

use CurrencyConverter\Currency\Currency;

/**
 * Value Object Money
 *
 * Class Money
 * @package CurrencyConverter\Money
 */
class Money
{
    /**
     * @var float
     */
    private $value;
    /**
     * @var Currency
     */
    private $currency;

    /**
     * Money constructor.
     * @param float $value
     * @param Currency $currency
     * @throws InvalidValueException
     */
    public function __construct($value, Currency $currency)
    {
        if (!is_numeric($value)) {
            throw new InvalidValueException();
        }

        $this->value = (float)$value;
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
     * @return float
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
}