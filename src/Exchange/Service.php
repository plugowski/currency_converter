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
     * @param \DateTimeInterface | null $date
     * @return Money
     */
    public function convert(Money $money, Currency $returnCurrency, \DateTimeInterface $date = null)
    {
        if (!isset($this->exchangeRateCollection)) {
            $date = is_null($date) ? new \DateTimeImmutable() : $date;
            $this->exchangeRateCollection = $this->exchangeRepository->getExchangeRates($date);
        }

        $converter = new Converter($this->exchangeRateCollection);
        return $converter->exchange($money, $returnCurrency);
    }

    /**
     * @return array
     */
    public function getCurrentExchangeTable()
    {
        return $this->getExchangeTableForDay(new \DateTimeImmutable('now'));
    }

    /**
     * @param \DateTimeInterface $date
     * @return array
     */
    public function getExchangeTableForDay(\DateTimeInterface $date)
    {
        if (!isset($this->exchangeRateCollection)) {
            $this->exchangeRateCollection = $this->exchangeRepository->getExchangeRates($date);
        }

        $exchangeRateTable = [];
        foreach ($this->exchangeRateCollection as $exchangeRate) {
            $exchangeRateTable[$exchangeRate->getCode()] = $exchangeRate->getValue();
        }
        return $exchangeRateTable;
    }
}