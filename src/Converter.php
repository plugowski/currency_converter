<?php
namespace CurrencyConverter;

/**
 * Class Converter
 * @package CurrencyConverter
 */
class Converter
{
    /**
     * @var ExchangeRateCollection
     */
    private $exchangeRateCollection;

    /**
     * Converter constructor.
     * @param ExchangeRateCollection $exchangeRateCollection
     */
    public function __construct(ExchangeRateCollection $exchangeRateCollection)
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
     * @return ExchangeRate
     * @throws ExchangeRateNotFoundException
     */
    public function findExchangeRate($code)
    {
        /** @var ExchangeRate $exchangeRate */
        foreach ($this->exchangeRateCollection as $exchangeRate) {
            if ($code === $exchangeRate->getCode()) {
                return $exchangeRate;
            }
        }
        throw new ExchangeRateNotFoundException($code);
    }
}