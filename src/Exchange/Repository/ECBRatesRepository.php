<?php
namespace CurrencyConverter\Exchange\Repository;

use CurrencyConverter\Exchange\Rate;
use CurrencyConverter\Exchange\RateCollection;
use CurrencyConverter\Exchange\Repository;

/**
 * European Central Bank
 *
 * Class ECBRepository
 * @package CurrencyConverter\Exchange\Repository
 */
class ECBRatesRepository implements Repository
{
    const API_URL = 'http://www.ecb.int/stats/eurofxref/eurofxref-daily.xml';

    /**
     * @return RateCollection | Rate[]
     */
    public function getExchangeRates()
    {
        $xml = simplexml_load_file(self::API_URL);

        $exchangeRateCollection = new RateCollection();
        // EUR is a base for all currencies, so exchange rate for EUR is 1:1
        $exchangeRateCollection->add(new Rate('EUR', 1.0000));

        foreach ($xml->Cube->Cube->Cube as $rate) {
            // Rate based on EUR should say how many EUR is in specified Currency, ECB return information how many
            // Currency units are in 1 EUR, so we have to inverse that
            $exchangeRateCollection->add(new Rate((string)$rate['currency'], 1 / (double)$rate['rate']));
        }

        return $exchangeRateCollection;
    }
}