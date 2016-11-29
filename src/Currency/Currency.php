<?php
namespace CurrencyConverter\Currency;

/**
 * Class Currency
 * @package CurrencyConverter\Currency
 */
class Currency
{
    /**
     * @var string
     */
    private $code;

    /**
     * Currency constructor.
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}