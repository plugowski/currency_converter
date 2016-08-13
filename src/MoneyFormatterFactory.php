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
     */
    public static function create($locale)
    {
        switch ($locale) {
            case 'pl_PL':
                $dictionary = new PolishCurrencyDictionary();
                break;
            default:
                // todo: throw exception dictionary not found
                break;
        }

        return new MoneyFormatter(NumberSpellerFactory::create($locale), $dictionary);
    }
}