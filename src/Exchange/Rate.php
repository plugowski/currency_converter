<?php
namespace CurrencyConverter\Exchange;

/**
 * Class Rate
 * @package CurrencyConverter\Exchange
 */
class Rate
{
    /**
     * @var string
     */
    private $code;
    /**
     * @var double
     */
    private $value;

    /**
     * ExchangeRate constructor.
     * @param string $code
     * @param double $value
     */
    public function __construct($code, $value)
    {
        $this->code = $code;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return double
     */
    public function getValue()
    {
        return $this->value;
    }
}