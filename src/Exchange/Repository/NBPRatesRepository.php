<?php
namespace CurrencyConverter\Exchange\Repository;

use CurrencyConverter\Currency\Currency;
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
    const API_URL = 'http://api.nbp.pl/api/exchangerates/';
    const EXCHANGE_TABLES = 'tables/';
    const EXCHANGE_RATES = 'rates/';

    /**
     * @param \DateTimeInterface $date
     * @return RateCollection | Rate[]
     */
    public function getExchangeRates(\DateTimeInterface $date)
    {
        $response = $this->call(self::EXCHANGE_TABLES . 'A/' . $date->format('Y-m-d'));

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
     * @param Currency $currency
     * @param \DateTimeInterface $date
     * @return Rate
     */
    public function getCurrencyRate(Currency $currency, \DateTimeInterface $date)
    {
        $response = $this->call(self::EXCHANGE_RATES . 'A/' . $currency->getCode() . '/' . $date->format('Y-m-d'));
        return new Rate($currency->getCode(), $response['rates'][0]['mid']);
    }

    /**
     * @param string $url
     * @return array
     * @throws \Exception
     */
    private function call($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::API_URL . $url . '?format=json');
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $body     = substr($response, curl_getinfo($ch, CURLINFO_HEADER_SIZE));

        if ($httpCode != 200) {
            throw new \Exception($httpCode);
        }

        return json_decode($body, true);
    }
}