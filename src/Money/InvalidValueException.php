<?php
namespace CurrencyConverter\Money;

/**
 * Class InvalidValueException
 * @package CurrencyConverter\Money
 */
class InvalidValueException extends \Exception
{
    /**
     * MoneyValueException constructor.
     */
    public function __construct()
    {
        parent::__construct('Value should be numeric!');
    }
}