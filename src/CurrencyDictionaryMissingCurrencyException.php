<?php
namespace CurrencyConverter;

/**
 * Class CurrencyDictionaryMissingCurrencyException
 * @package CurrencyConverter
 */
class CurrencyDictionaryMissingCurrencyException extends \Exception
{
    /**
     * CurrencyDictionaryTranslationNotFoundException constructor.
     * @param string $dictionary
     * @param int $currency
     */
    public function __construct($dictionary, $currency)
    {
        parent::__construct(sprintf('Currency %s not found in %s.', $currency, $dictionary));
    }
}