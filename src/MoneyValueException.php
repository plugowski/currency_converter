<?php
namespace CurrencyConverter;

/**
 * Class MoneyValueException
 * @package CurrencyConverter
 */
class MoneyValueException extends \Exception
{
    /**
     * MoneyValueException constructor.
     */
    public function __construct()
    {
        parent::__construct('Value should be numeric!');
    }
}