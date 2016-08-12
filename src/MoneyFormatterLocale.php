<?php
namespace CurrencyConverter;

/**
 * Class MoneyFormatterLocale
 * @package CurrencyConverter
 */
abstract class MoneyFormatterLocale extends MoneyFormatter
{
    /**
     * @var bool
     */
    private $withFloats = false;
    /**
     * @var bool
     */
    private $withSpelledFloats = false;
    /**
     * @var string
     */
    protected $floatConnector;

    /**
     * @param int $number
     * @param array $words
     * @return string
     */
    abstract protected function variety($number, array $words);

    /**
     * @param int $number
     * @return string
     */
    abstract protected function verbally($number);

    /**
     * @return string
     */
    public function spell()
    {
        return $this->getUnit() . $this->getFloats();
    }

    /**
     * @return string
     */
    private function getUnit()
    {
        return $this->verbally($this->unitValue);
    }

    /**
     * @return string
     */
    private function getFloats()
    {
        if (false === $this->withSpelledFloats && false === $this->withFloats || 0 == $this->floatValue) {
            return '';
        } else if (false === $this->withSpelledFloats) {
            return ' ' . $this->floatValue . '/100';
        }

        return $this->floatConnector . $this->verbally($this->floatValue);
    }

    /**
     * @return $this
     */
    public function withFloats()
    {
        $this->withFloats = true;
        return $this;
    }

    /**
     * @return $this
     */
    public function withSpelledFloats()
    {
        $this->withSpelledFloats = true;
        return $this;
    }

    /**
     * @param int $number
     * @return array
     */
    protected function splitNumber($number)
    {
        return array_reverse(array_map(function($element){ return (int)strrev($element); }, str_split(strrev($number), 3)));
    }
}