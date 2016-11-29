<?php
namespace CurrencyConverter\Money;

use CurrencyConverter\Currency\Currency;
use CurrencyConverter\Currency\CurrencyDictionary;
use NumberSpeller\NumberSpeller;

/**
 * Class Formatter
 * @package CurrencyConverter\Money
 */
class Formatter
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
     * @var NumberSpeller
     */
    private $numberSpeller;
    /**
     * @var CurrencyDictionary
     */
    private $currencyDictionary;

    /**
     * MoneyFormatter constructor.
     * @param NumberSpeller $numberSpeller
     * @param CurrencyDictionary $currencyDictionary
     */
    public function __construct(NumberSpeller $numberSpeller, CurrencyDictionary $currencyDictionary)
    {
        $this->numberSpeller = $numberSpeller;
        $this->currencyDictionary = $currencyDictionary;
    }

    /**
     * @param Money $money
     * @return $this
     */
    public function setMoney(Money $money)
    {
        $this->money = $money;
        $this->setParsedValues($money->getValue());
        $this->currencyDictionary->setCurrency($money->getCurrency()->getCode());
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
        $this->currencyDictionary->setCurrency($currency);
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
     * @return string
     */
    public function price()
    {
        return sprintf($this->currencyDictionary->getMoneyFormat(), $this->unitValue, $this->floatValue);
    }

    /**
     * @param bool $spellFloats
     * @param bool $forceZeros
     * @return string
     */
    public function spell($spellFloats = true, $forceZeros = false)
    {
        return vsprintf('%s %s%s', [
            $this->numberSpeller->verbally($this->unitValue),
            $this->numberSpeller->variety($this->unitValue, $this->currencyDictionary->getUnitNames()),
            $this->floats($spellFloats, $forceZeros)
        ]);
    }

    /**
     * @param $spellFloats
     * @param $forceZeros
     * @return string
     */
    private function floats($spellFloats, $forceZeros)
    {
        if (0 === $this->floatValue && false === $forceZeros) {
            $return = '';
        } else if (true === $spellFloats) {
            $return = ' ' . $this->numberSpeller->verbally($this->floatValue) . ' '
                . $this->numberSpeller->variety($this->floatValue, $this->currencyDictionary->getFloatNames());
        } else {
            $return = ' ' . $this->floatValue . '/100';
        }
        return $return;
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
        list($this->unitValue, $this->floatValue) = array_map(function($el) {
            return (int)$el;
        }, explode('.', number_format(abs($value), 2, '.', '')));
    }
}