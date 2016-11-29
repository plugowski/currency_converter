<?php
namespace CurrencyConverter\Currency;

/**
 * Class CurrencyDictionaryNotFoundException
 * @package CurrencyConverter\Currency
 */
class CurrencyDictionaryNotFoundException extends \Exception
{
    /**
     * CurrencyDictionaryNotFoundException constructor.
     * @param string $locale
     */
    public function __construct($locale)
    {
        parent::__construct(sprintf('Dictionary for locale %s not found. Please create new one and register in factory.', $locale));
    }
}