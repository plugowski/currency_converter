<?php
namespace CurrencyConverter;

/**
 * Class CurrencyDictionaryNotFoundException
 * @package CurrencyConverter
 */
class CurrencyDictionaryNotFoundException extends \Exception
{
    /**
     * CurrencyDictionaryNotFoundException constructor.
     */
    public function __construct($locale)
    {
        parent::__construct(sprintf('Dictionary for locale %s not found. Please create new one and register in factory.', $locale));
    }
}