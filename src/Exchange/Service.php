<?php
namespace CurrencyConverter\Exchange;

use CurrencyConverter\Converter;
use CurrencyConverter\Currency\Currency;
use CurrencyConverter\Money\Money;

/**
 * Class Service
 * @package CurrencyConverter\Exchange
 */
class Service
{
    /**
     * @var Repository
     */
    private $exchangeRepository;
    /**
     * @var RateCollection | Rate[]
     */
    private $exchangeRateCollection;

    /**
     * ExchangeService constructor.
     * @param Repository $exchangeRepository
     */
    public function __construct(Repository $exchangeRepository)
    {
        $this->exchangeRepository = $exchangeRepository;
    }

    /**
     * @param Money $money
     * @param Currency $returnCurrency
     * @return Money
     */
    public function convert(Money $money, Currency $returnCurrency)
    {
        if (!isset($this->exchangeRateCollection)) {
            $this->exchangeRateCollection = $this->exchangeRepository->getExchangeRates();
        }

        $converter = new Converter($this->exchangeRateCollection);
        return $converter->exchange($money, $returnCurrency);
    }

    /**
     * @return array
     */
    public function getExchangeTable()
    {
        if (!isset($this->exchangeRateCollection)) {
            $this->exchangeRateCollection = $this->exchangeRepository->getExchangeRates();
        }
        
        $exchangeRateTable = [];
        foreach ($this->exchangeRateCollection as $exchangeRate) {
            $exchangeRateTable[$exchangeRate->getCode()] = $exchangeRate->getValue();
        }
        return $exchangeRateTable;
    }
}