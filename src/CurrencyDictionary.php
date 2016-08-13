<?php
namespace CurrencyConverter;

/**
 * Class CurrencyDictionary
 * @package CurrencyConverter
 */
abstract class CurrencyDictionary
{
    /**
     * Consts for indexes in dictionaries
     */
    const UNIT_NAMES = 'unit_names';
    const FLOAT_NAMES = 'float_names';
    const MONEY_FORMAT = 'money_format';

    /**
     * @var array
     */
    protected $currencies;
    /**
     * @var string
     */
    private $currency;

    /**
     * @return mixed
     */
    public function getMoneyFormat()
    {
        return $this->currencies[$this->currency][self::MONEY_FORMAT];
    }

    /**
     * @return array
     */
    public function getUnitNames()
    {
        return $this->currencies[$this->currency][self::UNIT_NAMES];
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
     * @throws CurrencyDictionaryMissingCurrencyException
     */
    public function setCurrency($currency)
    {
        if (!array_key_exists($currency, $this->currencies)) {
            throw new CurrencyDictionaryMissingCurrencyException(
                substr(get_class($this), strrpos(get_class($this), '\\')+1),
                $currency
            );
        }

        $this->currency = $currency;
    }
}