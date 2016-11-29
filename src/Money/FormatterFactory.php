<?php
namespace CurrencyConverter\Money;

use CurrencyConverter\Currency\CurrencyDictionaryNotFoundException;
use CurrencyConverter\Currency\PolishCurrencyDictionary;
use NumberSpeller\NumberSpellerFactory;

/**
 * Class FormatterFactory
 * @package CurrencyConverter
 */
class FormatterFactory
{
    /**
     * @param string $locale
     * @return Formatter
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

        return new Formatter(NumberSpellerFactory::create($locale), $dictionary);
    }
}