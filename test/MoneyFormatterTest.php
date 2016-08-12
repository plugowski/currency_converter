<?php
namespace CurrencyConverterTest;

use CurrencyConverter\Money;
use CurrencyConverter\MoneyFormatter;
use CurrencyConverter\MoneyFormatterFactory;
use CurrencyConverter\MoneyFormatterLocaleNotFoundException;

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
        $this->setExpectedException(MoneyFormatterLocaleNotFoundException::class);
        MoneyFormatterFactory::create('NON_EXISTS');
    }

    /**
     * @test
     */
    public function shouldReturnFormattedMoneyValueByMoney()
    {
        $moneyFormatter = new MoneyFormatter();
        /** @noinspection PhpUndefinedMethodInspection */
        $moneyFormatter->setMoney(Money::PLN(10));

        self::assertEquals('10,00', $moneyFormatter->format(2, ',', ''));
    }

    /**
     * @test
     */
    public function shouldReturnFormattedMoneyValue()
    {
        $moneyFormatter = new MoneyFormatter();
        /** @noinspection PhpUndefinedMethodInspection */
        $moneyFormatter->setValue('1 000,55', 'PLN');

        self::assertEquals('1000.55', $moneyFormatter->format(2, '.', ''));
    }

    /**
     * @test
     */
    public function shouldSpelloutMoney()
    {
        $formatter = MoneyFormatterFactory::create('pl_PL');

        $test = [
            1 => 'jeden',
            2 => 'dwa',
            5 => 'pięć',
            10 => 'dziesięć',
            13 => 'trzynaście',
            20 => 'dwadzieścia',
            22 => 'dwadzieścia dwa',
            100 => 'sto',
            101 => 'sto jeden',
            200 => 'dwieście',
            120 => 'sto dwadzieścia',
            179 => 'sto siedemdziesiąt dziewięć',
            212 => 'dwieście dwanaście',
            279 => 'dwieście siedemdziesiąt dziewięć',
            1000 => 'jeden tysiąc',
            1001 => 'jeden tysiąc jeden',
            1200 => 'jeden tysiąc dwieście',
            4000 => 'cztery tysiące',
            100200000 => 'sto milionów dwieście tysięcy'
        ];

        foreach ($test as $value => $text) {
            /** @noinspection PhpUndefinedMethodInspection */
            self::assertEquals($text, $formatter->setMoney(Money::PLN($value))->spell());
        }
    }

    /**
     * @test
     */
    public function shouldSpellCurrencyWithFloatsAsString()
    {
        $formatter = MoneyFormatterFactory::create('pl_PL');
        $test = [
            '9.00' => 'dziewięć',
            '9.50' => 'dziewięć, pięćdziesiąt',
            '123.99' => 'sto dwadzieścia trzy, dziewięćdziesiąt dziewięć',
        ];

        foreach ($test as $value => $text) {
            /** @noinspection PhpUndefinedMethodInspection */
            $verbally = $formatter->setMoney(Money::PLN($value))
                ->withSpelledFloats()
                ->spell();

            self::assertEquals($text, $verbally);
        }
    }

    /**
     * @test
     */
    public function shouldSpellCurrencyWithShortFloats()
    {
        $formatter = MoneyFormatterFactory::create('pl_PL');
        $test = [
            '9.00' => 'dziewięć',
            '9.50' => 'dziewięć 50/100',
            '123.99' => 'sto dwadzieścia trzy 99/100',
        ];

        foreach ($test as $value => $text) {
            /** @noinspection PhpUndefinedMethodInspection */
            $verbally = $formatter->setMoney(Money::PLN($value))
                ->withFloats()
                ->spell();

            self::assertEquals($text, $verbally);
        }
    }
}