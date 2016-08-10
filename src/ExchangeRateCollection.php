<?php
namespace CurrencyConverter;

/**
 * Class ExchangeRateCollection
 * @package CurrencyConverter
 */
class ExchangeRateCollection implements \IteratorAggregate
{
    /**
     * @var ExchangeRate[]
     */
    private $exchangeRates = [];

    /**
     * @param ExchangeRate $exchangeRate
     */
    public function add(ExchangeRate $exchangeRate)
    {
        $this->exchangeRates[] = $exchangeRate;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->exchangeRates);
    }
}