<?php
namespace CurrencyConverter;

/**
 * Class MoneyFormatterLocaleNotFoundException
 * @package CurrencyConverter
 */
class MoneyFormatterLocaleNotFoundException extends \Exception
{
    /**
     * FormatterLocaleNotFoundException constructor.
     * @param string $locale
     */
    public function __construct($locale)
    {
        parent::__construct(sprintf("MoneyFormatterLocale for locale %s not found!", $locale));
    }
}