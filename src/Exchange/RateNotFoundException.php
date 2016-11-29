<?php
namespace CurrencyConverter\Exchange;

/**
 * Class ExchangeRateNotFoundException
 * @package CurrencyConverter\Exchange
 */
class RateNotFoundException extends \Exception
{
    /**
     * ExchangeRateNotFoundException constructor.
     * @param string $currencyCode
     */
    public function __construct($currencyCode)
    {
        parent::__construct(sprintf('Could not found currency with code: %s', $currencyCode));
    }
}