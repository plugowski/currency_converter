<?php
namespace CurrencyConverter\MoneyFormatterLocale;

use CurrencyConverter\MoneyFormatterLocale;
use NumberFormatter;


/**
 * Class NumberFormatter
 * @package CurrencyConverter\MoneyFormatterLocale
 */
class PeclFormatter extends MoneyFormatterLocale
{
    /**
     * @var NumberFormatter
     */
    private $formatter;

    /**
     * NumberFormatter constructor.
     * @param string $locale
     */
    public function __construct($locale)
    {
        $this->checkNumberFormatterExistence();
        $this->formatter = new NumberFormatter($locale, NumberFormatter::SPELLOUT);
    }

    /**
     * @param int $number
     * @return string
     */
    public function verbally($number)
    {
        return $this->formatter->format($number);
    }

    /**
     * @throws NumberFormatterNotFoundException
     */
    private function checkNumberFormatterExistence()
    {
        if (!class_exists(NumberFormatter::class)) {
            throw new NumberFormatterNotFoundException();
        }
    }

    /**
     * @param int $number
     * @param array $words
     * @return string
     */
    protected function variety($number, array $words)
    {
        return 1 === $number ? $words[0] : $words[1];
    }
}