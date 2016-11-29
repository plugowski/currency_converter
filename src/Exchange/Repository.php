<?php
namespace CurrencyConverter\Exchange;

use CurrencyConverter\Currency\Currency;

/**
 * Interface Repository
 * @package CurrencyConverter\Exchange
 */
interface Repository
{
    /**
     * @param \DateTimeInterface $date
     * @return Rate[]|RateCollection
     */
    public function getExchangeRates(\DateTimeInterface $date);

    /**
     * @param Currency $currency
     * @param \DateTimeInterface $date
     * @return Rate
     */
    public function getCurrencyRate(Currency $currency, \DateTimeInterface $date);
}