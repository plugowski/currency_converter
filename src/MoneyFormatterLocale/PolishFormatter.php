<?php
namespace CurrencyConverter\MoneyFormatterLocale;

use CurrencyConverter\MoneyFormatterLocale;

/**
 * Class Polish
 * @package CurrencyConverter\MoneyFormatterLocale
 */
final class PolishFormatter extends MoneyFormatterLocale
{
    protected $locale = 'pl_PL';

    protected $unitSign = 'zł';
    protected $floatSign = 'gr';

    protected $unitName = ['złoty', 'złote', 'złotych'];
    protected $floatName = ['grosz', 'grosze', 'groszy'];

    protected $floatConnector = ', ';

    private $units = ['zero', 'jeden', 'dwa', 'trzy', 'cztery', 'pięć', 'sześć', 'siedem', 'osiem', 'dziewięć'];
    private $teens = [
        'jedenaście',
        'dwanaście',
        'trzynaście',
        'czternaście',
        'piętnaście',
        'szesnaście',
        'siedemnaście',
        'osiemnaście',
        'dziewiętnaście'
    ];
    private $dozens = [
        'dziesięć',
        'dwadzieścia',
        'trzydzieści',
        'czterdzieści',
        'pięćdziesiąt',
        'sześćdziesiąt',
        'siedemdziesiąt',
        'osiemdziesiąt',
        'dziewięćdziesiąt'
    ];
    private $hundreds = [
        'sto',
        'dwieście',
        'trzysta',
        'czterysta',
        'pięćset',
        'sześćset',
        'siedemset',
        'osiemset',
        'dziewięćset'
    ];
    private $thousands = [
        ['tysiąc', 'tysiące', 'tysięcy'],
        ['milion', 'miliony', 'milionów'], 
        ['miliard', 'miliardy', 'miliardów'],
        ['bilion', 'biliony', 'bilionów'],
        ['biliard', 'biliardy', 'biliardów'],
        ['trylion', 'tryliony', 'trylionów'],
        ['tryliard', 'tryliardy', 'tryliardów'],
        ['kwadrylion', 'kwadryliony', 'kwadrylionów'],
        ['kwadryliard', 'kwadryliardy', 'kwadryliardów'],
        ['kwintylion', 'kwintyliony', 'kwintylionów'],
        ['kwintyliard', 'kwintyliardy', 'kwintyliardów'],
        ['sekstylion', 'sekstyliony', 'sekstylionów'],
        ['sekstyliard', 'sekstyliardy', 'sekstyliardów'],
    ];

    /**
     * @param int $number
     * @return string
     */
    public function verbally($number)
    {
        $parts = $this->splitNumber($number);
        $multiplier = count($parts);

        $spelled = [];
        foreach ($parts as $number) {
            if (0 === $number) {
                continue;
            }
            $spelled[] = $this->translate($number);
            if (--$multiplier > 0) {
                $spelled[] = $this->variety($number, $this->thousands[$multiplier - 1]);
            }
        }
        return implode(' ', $spelled);
    }

    /**
     * @param int $number
     * @param array $words
     * @return string
     */
    protected function variety($number, array $words)
    {
        $rest = $number % 100;
        if (1 === $rest && 100 > $number) {
            $word = $words[0];
        } else if (($rest % 10 > 1 && $rest % 10 < 5) && ($rest < 12 || $rest > 14)) {
            $word = $words[1];
        } else {
            $word = $words[2];
        }
        return $word;
    }

    /**
     * @param int $number
     * @return string
     */
    private function translate($number)
    {
        if (10 > $number) {
            $spelled = $this->units[$number];
        } else if (20 > $number && 10 != $number) {
            $spelled = $this->teens[$number - 11];
        } else if (100 > $number && 0 === $number % 10) {
            $spelled = $this->dozens[(int)($number/10 - 1)];
        } else if (0 === $number % 100) {
            $spelled = $this->hundreds[(int)($number / 100 - 1)];
        } else if (20 < $number && 100 > $number) {
            $spelled  = $this->translate(floor($number / 10) * 10);
            $spelled .= (0 !== $number % 10) ? ' ' . $this->translate($number % 10) : '';
        } else {
            $hundred = floor($number/100) * 100;
            $spelled  = 0 < $hundred ? $this->translate($hundred) . ' ' : '';
            $spelled .= $this->translate($number - $hundred);
        }
        return $spelled;
    }
}