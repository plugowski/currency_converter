<?php
namespace CurrencyConverter;

use CurrencyConverter\MoneyFormatterLocale\NumberFormatterNotFoundException;
use CurrencyConverter\MoneyFormatterLocale\PeclFormatter;
use CurrencyConverter\MoneyFormatterLocale\PolishFormatter;

/**
 * Class MoneyFormatterFactory
 * @package CurrencyConverter
 */
class MoneyFormatterFactory
{
    /**
     * @param string $locale
     * @return MoneyFormatterLocale
     */
    public static function create($locale)
    {
        try {
            $formatter = new PeclFormatter($locale);
        }  catch (NumberFormatterNotFoundException $e) {
            $formatter = self::getFormatter($locale);
        }
        return $formatter;
    }

    /**
     * @param string $locale
     * @return PolishFormatter
     * @throws MoneyFormatterLocaleNotFoundException
     */
    private static function getFormatter($locale)
    {
        switch ($locale) {
            case 'pl_PL' :
            case 'pl' :
                $formatter = new PolishFormatter();
                break;
            default :
                throw new MoneyFormatterLocaleNotFoundException($locale);
                break;
        }
        return $formatter;
    }
}