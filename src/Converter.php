<?php
namespace CurrencyConverter;

use CurrencyConverter\Currency\Currency;
use CurrencyConverter\Exchange\Rate;
use CurrencyConverter\Exchange\RateCollection;
use CurrencyConverter\Exchange\RateNotFoundException;
use CurrencyConverter\Money\Money;

/**
 * Class Converter
 * @package CurrencyConverter
 */
class Converter
{
    /**
     * @var RateCollection
     */
    private $exchangeRateCollection;

    /**
     * Converter constructor.
     * @param RateCollection $exchangeRateCollection
     */
    public function __construct(RateCollection $exchangeRateCollection)
    {
        $this->exchangeRateCollection = $exchangeRateCollection;
    }

    /**
     * @param Money $money
     * @param Currency $currency
     * @return Money
     */
    public function exchange(Money $money, Currency $currency)
    {
        $baseRate = $this->findExchangeRate($money->getCurrency()->getCode());
        $exchangeRate = $this->findExchangeRate($currency->getCode());
        $value = ($money->getValue() * $baseRate->getValue()) / $exchangeRate->getValue();

        return new Money($value, $currency);
    }

    /**
     * @param string $code
     * @return Rate
     * @throws RateNotFoundException
     */
    public function findExchangeRate($code)
    {
        /** @var Rate $exchangeRate */
        foreach ($this->exchangeRateCollection as $exchangeRate) {
            if ($code === $exchangeRate->getCode()) {
                return $exchangeRate;
            }
        }
        throw new RateNotFoundException($code);
    }
}