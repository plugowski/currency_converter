<?php
namespace CurrencyConverter;

/**
 * Class PolishCurrencyDictionary
 * @package CurrencyConverter
 */
class PolishCurrencyDictionary extends CurrencyDictionary
{
    protected $locale = 'pl_PL';

    protected $currencies = [
        'PLN' => [
            self::UNIT_SIGN => 'zł',
            self::FLOAT_SIGN => 'gr',
            self::UNIT_NAMES => ['złoty', 'złote', 'złotych'],
            self::FLOAT_NAMES => ['grosz', 'grosze', 'groszy']
        ],
        'USD' => [
            self::UNIT_SIGN => '$',
            self::FLOAT_SIGN => '¢',
            self::UNIT_NAMES => ['dolar', 'dolary', 'dolarów'],
            self::FLOAT_NAMES => ['cent', 'centy', 'centów']
        ],
        'EUR' => [
            self::UNIT_SIGN => '€',
            self::FLOAT_SIGN => '¢',
            self::UNIT_NAMES => ['euro', 'euro', 'euro'],
            self::FLOAT_NAMES => ['eurocent', 'eurocenty', 'eurocentów']
        ],
        'GBP' => [
            self::UNIT_SIGN => '£',
            self::FLOAT_SIGN => 'd',
            self::UNIT_NAMES => ['funt', 'funty', 'funtów'],
            self::FLOAT_NAMES => ['pens', 'pensy', 'pensów']
        ],
    ];
}