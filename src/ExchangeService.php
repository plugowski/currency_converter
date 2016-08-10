<?php
namespace CurrencyConverter;

/**
 * Class ExchangeService
 * @package CurrencyConverter
 */
class ExchangeService
{
    /**
     * @var ExchangeRepository
     */
    private $exchangeRepository;
    /**
     * @var ExchangeRateCollection | ExchangeRate[]
     */
    private $exchangeRateCollection;

    /**
     * ExchangeService constructor.
     * @param ExchangeRepository $exchangeRepository
     */
    public function __construct(ExchangeRepository $exchangeRepository)
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