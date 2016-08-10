<?php
namespace CurrencyConverter;

/**
 * Class ExchangeRateNotFoundException
 * @package CurrencyConverter
 */
class ExchangeRateNotFoundException extends \Exception
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