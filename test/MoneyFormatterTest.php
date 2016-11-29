<?php
namespace CurrencyConverterTest;

use CurrencyConverter\Currency\Currency;
use CurrencyConverter\Currency\CurrencyDictionaryMissingCurrencyException;
use CurrencyConverter\Currency\CurrencyDictionaryNotFoundException;
use CurrencyConverter\Money\Money;
use CurrencyConverter\Money\FormatterFactory;

/**
 * Class MoneyFormatterTest
 * @package CurrencyConverterTest
 */
class MoneyFormatterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function shouldThrowLocaleNotFoundException()
    {
        $this->setExpectedException(CurrencyDictionaryNotFoundException::class);
        FormatterFactory::create('NON_EXISTS');
    }

    /**
     * @test
     */
    public function shouldThrowMissingCurrencyInDictionaryException()
    {
        $this->setExpectedException(CurrencyDictionaryMissingCurrencyException::class);
        /** @noinspection PhpUndefinedMethodInspection */
        FormatterFactory::create('pl_PL')->setMoney(Money::AUD(10));
    }

    /**
     * @test
     */
    public function shouldSpellByValueAndCurrencyCode()
    {
        $formatter = FormatterFactory::create('pl_PL');
        $test = [
            '25.02' => 'dwadzieścia pięć dolarów dwa centy',
            '10,50' => 'dziesięć dolarów pięćdziesiąt centów',
        ];

        foreach ($test as $value => $text) {
            self::assertEquals($text, $formatter->setValue($value, 'USD')->spell());
        }
    }

    /**
     * @test
     */
    public function shouldFormatMoneyUsingNumberFormat()
    {
        $formatter = FormatterFactory::create('pl_PL');
        self::assertEquals('10 000,00', $formatter->setValue(10000, 'USD')->format(2, ',', ' '));
    }

    /**
     * @test
     */
    public function shouldSpellAmountWithCurrencyName()
    {
        $formatter = FormatterFactory::create('pl_PL');
        $test = [
            '9.00' => 'dziewięć złotych',
            '1.03' => 'jeden złoty trzy grosze',
            '9.50' => 'dziewięć złotych pięćdziesiąt groszy',
            '123.99' => 'sto dwadzieścia trzy złote dziewięćdziesiąt dziewięć groszy',
        ];

        foreach ($test as $value => $text) {
            /** @noinspection PhpUndefinedMethodInspection */
            self::assertEquals($text, $formatter->setMoney(Money::PLN($value))->spell());
        }
    }

    /**
     * @test
     */
    public function shouldSpellAmountWithForcedZeros()
    {
        $formatter = FormatterFactory::create('pl_PL');
        $test = [
            '1' => 'jeden złoty zero groszy',
            '2' => 'dwa złote zero groszy',
            '9.00' => 'dziewięć złotych zero groszy'
        ];

        foreach ($test as $value => $text) {
            /** @noinspection PhpUndefinedMethodInspection */
            self::assertEquals($text, $formatter->setMoney(Money::PLN($value))->spell(true, true));
        }
    }

    /**
     * @test
     */
    public function shouldSpellAmountWithNumericalFloats()
    {
        $formatter = FormatterFactory::create('pl_PL');
        $test = [
            '1.33' => 'jeden złoty 33/100',
            '2.50' => 'dwa złote 50/100',
            '9.99' => 'dziewięć złotych 99/100',
            '10' => 'dziesięć złotych'
        ];

        foreach ($test as $value => $text) {
            /** @noinspection PhpUndefinedMethodInspection */
            self::assertEquals($text, $formatter->setMoney(Money::PLN($value))->spell(false));
        }
    }

    /**
     * @test
     * @dataProvider otherCurrenciesDataProvider
     * @param $currency
     * @param $data
     */
    public function shouldSpellAmountInOtherCurrencies($currency, $data)
    {
        $formatter = FormatterFactory::create('pl_PL');
        foreach ($data as $value => $text) {
            /** @noinspection PhpUndefinedMethodInspection */
            self::assertEquals($text, $formatter->setMoney(new Money($value, new Currency($currency)))->spell());
        }
    }

    /**
     * @return array
     */
    public function otherCurrenciesDataProvider()
    {
        return [
            [
                'PLN', [
                    '1' => 'jeden złoty',
                    '1.50' => 'jeden złoty pięćdziesiąt groszy'
                ]
            ],
            [
                'EUR', [
                    '2' => 'dwa euro',
                    '3.99' => 'trzy euro dziewięćdziesiąt dziewięć eurocentów'
                ]
            ],
            [   'USD', [
                    '5' => 'pięć dolarów',
                    '10.01' => 'dziesięć dolarów jeden cent'
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider shortPriceFormatDataProvider
     * @param $currency
     * @param $data
     */
    public function shouldReturnPriceFormatWithShortCurrencySigns($currency, $data)
    {
        $formatter = FormatterFactory::create('pl_PL');
        foreach ($data as $value => $text) {
            /** @noinspection PhpUndefinedMethodInspection */
            self::assertEquals($text, $formatter->setMoney(new Money($value, new Currency($currency)))->price());
        }
    }

    /**
     * @return array
     */
    public function shortPriceFormatDataProvider()
    {
        return [
            ['USD', ['1.33' => '$1.33', '1' => '$1.00']],
            ['PLN', ['2.50' => '2zł 50gr', '1.01' => '1zł 1gr']],
            ['GBP', ['9.99' => '£9.99']],
            ['EUR', ['10' => '€10.00']]
        ];
    }
}