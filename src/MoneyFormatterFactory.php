<?php
namespace CurrencyConverter;

use NumberSpeller\NumberSpellerFactory;

/**
 * Class MoneyFormatterFactory
 * @package CurrencyConverter
 */
class MoneyFormatterFactory
{
    /**
     * @param string $locale
     * @return MoneyFormatter
     * @throws CurrencyDictionaryNotFoundException
     */
    public static function create($locale)
    {
        switch ($locale) {
            case 'pl_PL':
                $dictionary = new PolishCurrencyDictionary();
                break;
            default:
                throw new CurrencyDictionaryNotFoundException($locale);
                break;
        }

        return new MoneyFormatter(NumberSpellerFactory::create($locale), $dictionary);
    }
}