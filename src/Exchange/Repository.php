<?php
namespace CurrencyConverter\Exchange;

/**
 * Interface Repository
 * @package CurrencyConverter\Exchange
 */
interface Repository
{
    /**
     * @return RateCollection | Rate[]
     */
    public function getExchangeRates();
}