<?php
namespace CurrencyConverterTest;

use CurrencyConverter\Currency;
use CurrencyConverter\CurrencyDictionaryMissingCurrencyException;
use CurrencyConverter\CurrencyDictionaryNotFoundException;
use CurrencyConverter\Money;
use CurrencyConverter\MoneyFormatterFactory;

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
        MoneyFormatterFactory::create('NON_EXISTS');
    }

    /**
     * @test
     */
    public function shouldThrowMissingCurrencyInDictionaryException()
    {
        $this->setExpectedException(CurrencyDictionaryMissingCurrencyException::class);
        /** @noinspection PhpUndefinedMethodInspection */
        MoneyFormatterFactory::create('pl_PL')->setMoney(Money::AUD(10));
    }

    /**
     * @test
     */
    public function shouldSpellByValueAndCurrencyCode()
    {
        $formatter = MoneyFormatterFactory::create('pl_PL');
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
        $formatter = MoneyFormatterFactory::create('pl_PL');
        self::assertEquals('10 000,00', $formatter->setValue(10000, 'USD')->format(2, ',', ' '));
    }

    /**
     * @test
     */
    public function shouldSpellAmountWithCurrencyName()
    {
        $formatter = MoneyFormatterFactory::create('pl_PL');
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
        $formatter = MoneyFormatterFactory::create('pl_PL');
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
        $formatter = MoneyFormatterFactory::create('pl_PL');
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
     */
    public function shouldSpellAmountInOtherCurrencies()
    {
        $formatter = MoneyFormatterFactory::create('pl_PL');
        $test = [
            'PLN' => [
                '1' => 'jeden złoty',
                '1.50' => 'jeden złoty pięćdziesiąt groszy'
            ],
            'EUR' => [
                '2' => 'dwa euro',
                '3.99' => 'trzy euro dziewięćdziesiąt dziewięć eurocentów'
            ],
            'USD' => [
                '5' => 'pięć dolarów',
                '10.01' => 'dziesięć dolarów jeden cent'
            ]
        ];

        foreach ($test as $currency => $data) {
            foreach ($data as $value => $text) {
                /** @noinspection PhpUndefinedMethodInspection */
                self::assertEquals($text, $formatter->setMoney(new Money($value, new Currency($currency)))->spell());
            }
        }
    }

    /**
     * @test
     */
    public function shouldReturnPriceFormatWithShortCurrencySigns()
    {
        $formatter = MoneyFormatterFactory::create('pl_PL');
        $test = [
            'USD' => ['1.33' => '$1.33', '1' => '$1.00'],
            'PLN' => ['2.50' => '2zł 50gr', '1.01' => '1zł 1gr'],
            'GBP' => ['9.99' => '£9.99'],
            'EUR' => ['10' => '€10.00']
        ];

        foreach ($test as $currency => $data) {
            foreach ($data as $value => $text) {
                /** @noinspection PhpUndefinedMethodInspection */
                self::assertEquals($text, $formatter->setMoney(new Money($value, new Currency($currency)))->price());
            }
        }
    }
}