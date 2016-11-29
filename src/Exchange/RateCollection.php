<?php
namespace CurrencyConverter\Exchange;

/**
 * Class Collection
 * @package CurrencyConverter\Exchange
 */
class RateCollection implements \IteratorAggregate
{
    /**
     * @var Rate[]
     */
    private $exchangeRates = [];

    /**
     * @param Rate $exchangeRate
     */
    public function add(Rate $exchangeRate)
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