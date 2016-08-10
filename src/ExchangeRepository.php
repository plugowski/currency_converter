<?php
namespace CurrencyConverter;

/**
 * Interface ExchangeRepository
 * @package CurrencyConverter
 */
interface ExchangeRepository
{
    /**
     * @return ExchangeRateCollection | ExchangeRate[]
     */
    public function getExchangeRates();
}