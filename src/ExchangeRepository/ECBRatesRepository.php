<?php
namespace CurrencyConverter\ExchangeRepository;

use CurrencyConverter\ExchangeRate;
use CurrencyConverter\ExchangeRateCollection;
use CurrencyConverter\ExchangeRepository;

/**
 * European Central Bank
 *
 * Class ECBRepository
 * @package CurrencyConverter\ExchangeRepository
 */
class ECBRatesRepository implements ExchangeRepository
{
    const API_URL = 'http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml';

    /**
     * @return ExchangeRateCollection | ExchangeRate[]
     */
    public function getExchangeRates()
    {
        $xml = simplexml_load_file(self::API_URL);

        $exchangeRateCollection = new ExchangeRateCollection();
        // EUR is a base for all currencies, so exchange rate for EUR is 1:1
        $exchangeRateCollection->add(new ExchangeRate('EUR', 1.0000));

        foreach ($xml->Cube->Cube->Cube as $rate) {
            // Rate based on EUR should say how many EUR is in specified Currency, ECB return information how many
            // Currency units are in 1 EUR, so we have to convert that
            $exchangeRateCollection->add(new ExchangeRate((string)$rate['currency'], 1 / (double)$rate['rate']));
        }

        return $exchangeRateCollection;
    }
}