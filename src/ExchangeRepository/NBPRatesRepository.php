<?php
namespace CurrencyConverter\ExchangeRepository;

use CurrencyConverter\ExchangeRate;
use CurrencyConverter\ExchangeRateCollection;
use CurrencyConverter\ExchangeRepository;

/**
 * Narodowy Bank Polski
 *
 * Class NBPExchangeRepository
 * @package CurrencyConverter
 */
class NBPRatesRepository implements ExchangeRepository
{
    /**
     * Adresy oraz endpointy do API
     */
    const API_URL = 'http://api.nbp.pl/api/';
    const EXCHANGE_RATES_URL = 'exchangerates/';

    /**
     * @return ExchangeRateCollection | ExchangeRate[]
     */
    public function getExchangeRates()
    {
        $response = $this->call(self::EXCHANGE_RATES_URL . 'tables/A');

        $exchangeRateCollection = new ExchangeRateCollection();
        // PLN is a base for all currencies, so exchange rate for PLN is 1:1
        $exchangeRateCollection->add(new ExchangeRate('PLN', 1.0000));

        if (!empty($response[0]['rates'])) {
            foreach ($response[0]['rates'] as $rate) {
                $exchangeRateCollection->add(new ExchangeRate($rate['code'], $rate['mid']));
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