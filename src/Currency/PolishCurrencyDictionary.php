<?php
namespace CurrencyConverter\Currency;

/**
 * Class PolishCurrencyDictionary
 * @package CurrencyConverter\Currency
 */
class PolishCurrencyDictionary extends CurrencyDictionary
{
    protected $locale = 'pl_PL';

    protected $currencies = [
        'PLN' => [
            self::MONEY_FORMAT => '%dzł %dgr',
            self::UNIT_NAMES => ['złoty', 'złote', 'złotych'],
            self::FLOAT_NAMES => ['grosz', 'grosze', 'groszy']
        ],
        'USD' => [
            self::MONEY_FORMAT => '$%d.%02d',
            self::UNIT_NAMES => ['dolar', 'dolary', 'dolarów'],
            self::FLOAT_NAMES => ['cent', 'centy', 'centów']
        ],
        'EUR' => [
            self::MONEY_FORMAT => '€%d.%02d',
            self::UNIT_NAMES => ['euro', 'euro', 'euro'],
            self::FLOAT_NAMES => ['eurocent', 'eurocenty', 'eurocentów']
        ],
        'GBP' => [
            self::MONEY_FORMAT => '£%d.%02d',
            self::UNIT_NAMES => ['funt', 'funty', 'funtów'],
            self::FLOAT_NAMES => ['pens', 'pensy', 'pensów']
        ],
    ];
}