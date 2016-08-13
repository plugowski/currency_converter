<?php
namespace CurrencyConverter;

/**
 * Class CurrencyDictionary
 * @package CurrencyConverter
 */
abstract class CurrencyDictionary
{
    const UNIT_SIGN = 'unit_sign';
    const FLOAT_SIGN = 'float_sign';
    const UNIT_NAMES = 'unit_names';
    const FLOAT_NAMES = 'float_names';

    /**
     * @var array
     */
    protected $currencies;
    /**
     * @var string
     */
    private $currency;

    /**
     * @return string
     */
    public function getUnitSign()
    {
        return $this->currencies[$this->currency][self::UNIT_SIGN];
    }

    /**
     * @return array
     */
    public function getUnitNames()
    {
        return $this->currencies[$this->currency][self::UNIT_NAMES];
    }

    /**
     * @return string
     */
    public function getFloatSign()
    {
        return $this->currencies[$this->currency][self::FLOAT_SIGN];
    }

    /**
     * @return array
     */
    public function getFloatNames()
    {
        return $this->currencies[$this->currency][self::FLOAT_NAMES];
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        if (!array_key_exists($currency, $this->currencies)) {
//            throw new CurrencyTranslationNotFound();
        }

        $this->currency = $currency;
    }
}