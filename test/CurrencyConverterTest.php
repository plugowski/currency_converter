<?php
namespace CurrencyConverterTest;

use CurrencyConverter\Converter;
use CurrencyConverter\Currency\Currency;
use CurrencyConverter\Exchange\Rate;
use CurrencyConverter\Exchange\RateCollection;
use CurrencyConverter\Exchange\RateNotFoundException;
use CurrencyConverter\Money\Money;
use CurrencyConverter\Money\InvalidValueException;

/**
 * Class CurrencyTest
 * @package CurrencyConverterTest
 */
class CurrencyConverterTest extends \PHPUnit_Framework_TestCase
{
    const RATE_EUR = 4.2693;
    const RATE_PLN = 1;

    /**
     * @test
     */
    public function shouldGetMoneyInstance()
    {
        $money = new Money(4, new Currency('EUR'));
        self::assertInstanceOf(Money::class, $money);
        self::assertEquals(4, $money->getValue());
        self::assertEquals('EUR', $money->getCurrency()->getCode());

        /** @var Money $money */
        /** @noinspection PhpUndefinedMethodInspection */
        $money = Money::PLN(5);
        self::assertInstanceOf(Money::class, $money);
        self::assertEquals(5, $money->getValue());
        self::assertEquals('PLN', $money->getCurrency()->getCode());
    }

    /**
     * @test
     */
    public function shouldThrowWrongValueExcepton()
    {
        $this->setExpectedException(InvalidValueException::class);
        /** @noinspection PhpUndefinedMethodInspection */
        Money::PLN('dziesiec');
    }

    /**
     * @test
     */
    public function shouldCreateCurrency()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $money = Money::EUR(1);

        $rateCollection = new RateCollection();
        $rateCollection->add(new Rate('PLN', self::RATE_PLN));
        $rateCollection->add(new Rate('EUR', self::RATE_EUR));

        $converter = new Converter($rateCollection);
        $converted = $converter->exchange($money, new Currency('PLN'));

        self::assertEquals(self::RATE_EUR, $converted->getValue());
    }

    /**
     * @test
     */
    public function shouldThrowExchangeRateNotFoundException()
    {
        $this->setExpectedException(RateNotFoundException::class);

        $rateCollection = new RateCollection();
        $rateCollection->add(new Rate('PLN', self::RATE_PLN));
        $rateCollection->add(new Rate('EUR', self::RATE_EUR));
        (new Converter($rateCollection))->findExchangeRate('USD');
    }
}