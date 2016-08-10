# CurrencyConverter ![alt text](https://img.shields.io/badge/licence-BSD--3--Clause-blue.svg "Licence") ![alt text](https://img.shields.io/badge/tests-19%20%2F%2019-brightgreen.svg "Tests") ![alt text](https://img.shields.io/badge/coverage-100%25-green.svg "Coverage")
Currency converter with service to get latest currencies from NBP (Narodowy Bank Polski) and ECB (European Central Bank).

## Installation

Just clone that repository or use composer:

```bash
composer require plugowski/currency_converter
```
 
## Usage
 
Basic usage looks like code below:
 
```php
<?php
require __DIR__ . '/vendor/autoload.php';

use CurrencyConverter\Converter;
use CurrencyConverter\Currency;
use CurrencyConverter\Money;
use CurrencyConverter\ExchangeRepository\NBPRatesRepository;

$money = Money::EUR(1);
$rateCollection = (new NBPRatesRepository())->getExchangeRates();

$converter = new Converter($rateCollection);
$converted = $converter->exchange($money, new Currency('PLN'));

// how many PLN are in 1 EUR
echo $converted->getValue();
```

Service usage:

```php
<?php
$exchangeService = new ExchangeService(new NBPRatesRepository());
$converted = $exchangeService->convert(Money::EUR(4), new Currency('PLN'));
```

## Licence

New BSD Licence: https://opensource.org/licenses/BSD-3-Clause