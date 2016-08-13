<?php
namespace CurrencyConverter;

use NumberSpeller\NumberSpeller;

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

    public function price()
    {
        return $this->unitValue . $this->currencyDictionary->getUnitSign() . ' '
            . $this->floatValue . $this->currencyDictionary->getFloatSign();
    }

    /**
     * @return string
     */
    public function spell()
    {
        list($unit, $unitName, $float, $floatName) = [
            $this->getUnit(),
            $this->numberSpeller->variety($this->unitValue, $this->currencyDictionary->getUnitNames()),
            $this->getFloats(),
            $this->numberSpeller->variety($this->unitValue, $this->currencyDictionary->getFloatNames())
        ];

        return sprintf('%s %s %s %s', $unit, $unitName, $float, $floatName);
    }

    /**
     * @return string
     */
    private function getUnit()
    {
        return $this->numberSpeller->verbally($this->unitValue);
    }

    /**
     * @return string
     */
    private function getFloats()
    {
//        if (false === $this->withSpelledFloats && false === $this->withFloats || 0 == $this->floatValue) {
//            return '';
//        } else if (false === $this->withSpelledFloats) {
//            return ' ' . $this->floatValue . '/100';
//        }

        return $this->numberSpeller->verbally($this->floatValue);
//        return $this->floatConnector . $this->numberSpeller->verbally($this->floatValue);
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