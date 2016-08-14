# CurrencyConverter ![alt text](https://img.shields.io/badge/licence-BSD--3--Clause-blue.svg "Licence") ![alt text](https://img.shields.io/badge/tests-13%20%2F%2013-brightgreen.svg "Tests") ![alt text](https://img.shields.io/badge/coverage-100%25-green.svg "Coverage")
Currency converter with service to get latest currencies from NBP (Narodowy Bank Polski) and ECB (European Central Bank). 
Converter has got built-in number speller which convert price into words with specified currency.

## Installation

Just clone that repository (remember about [NumberSpeller](https://github.com/plugowski/number_speller) dependency) or just use composer:

```bash
composer require plugowski/currency_converter
```
 
## Usage
 
Basic usage looks like code below:
 
```php
<?php
require __DIR__ . '/vendor/autoload.php';

$money = new CurrencyConverter\Money(1, new CurrencyConverter\Currency('EUR'));

$rateCollection =  new \CurrencyConverter\ExchangeRateCollection();
$rateCollection->add(new \CurrencyConverter\ExchangeRate('EUR', 4.2636));
$rateCollection->add(new \CurrencyConverter\ExchangeRate('PLN', 1.0000));

$converter = new CurrencyConverter\Converter($rateCollection);
$converted = $converter->exchange($money, new CurrencyConverter\Currency('PLN'));

// how many PLN are in 1 EUR
echo $converted->getValue();
```

Using money factory using magic static methods, just call Money::CURRENCY_CODE(float $value):

```php
$money = Money::EUR(1);
```

In example above we create exchange rates collection manually, but you can use service to get exchange rates from
third party services like NBP or ECB.

Service usage:

```php
<?php
$exchangeService = new CurrencyConverter\ExchangeService(new CurrencyConverter\ExchangeRepository\NBPRatesRepository());
$converted = $exchangeService->convert(CurrencyConverter\Money::EUR(4), new CurrencyConverter\Currency('PLN'));
```

## MoneyFormatter

For some cases we need show money value as spelled string like. For that case you can use built-in formatter.

```php
<?php
$formatter = \CurrencyConverter\MoneyFormatterFactory::create('pl_PL');
$formatter->setMoney(Money::PLN(20.99));

echo $formatter->spell(); // will return: dwadzieścia złotych dziewięćdziesiąt dziewięć groszy
```

Of course you are able to change return format, please chect tests for more examples.

## Licence

New BSD Licence: https://opensource.org/licenses/BSD-3-Clause