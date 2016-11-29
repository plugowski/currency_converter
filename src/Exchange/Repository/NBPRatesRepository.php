<?php
namespace CurrencyConverter\Exchange\Repository;

use CurrencyConverter\Exchange\Rate;
use CurrencyConverter\Exchange\RateCollection;
use CurrencyConverter\Exchange\Repository;

/**
 * Narodowy Bank Polski
 *
 * Class NBPExchangeRepository
 * @package CurrencyConverter\Exchange\Repository
 */
class NBPRatesRepository implements Repository
{
    /**
     * Adresy oraz endpointy do API
     */
    const API_URL = 'http://api.nbp.pl/api/';
    const EXCHANGE_RATES_URL = 'exchangerates/';
    const EXCHANGE_TABLES = 'tables/';
    const EXCHANGE_RATES = 'rates/';

    /**
     * @return RateCollection | Rate[]
     */
    public function getExchangeRates()
    {
        $response = $this->call(self::EXCHANGE_RATES_URL . 'tables/A');

        $exchangeRateCollection = new RateCollection();
        // PLN is a base for all currencies, so exchange rate for PLN is 1:1
        $exchangeRateCollection->add(new Rate('PLN', 1.0000));

        if (!empty($response[0]['rates'])) {
            foreach ($response[0]['rates'] as $rate) {
                $exchangeRateCollection->add(new Rate($rate['code'], $rate['mid']));
            }
        }

        return $exchangeRateCollection;
    }

    /**
     * @param string $url
     * @return array
     */
    private function call($url)
    {
        $response = file_get_contents(self::API_URL . $url . '?format=json');
        return json_decode($response, true);
    }
}