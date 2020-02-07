<?php

namespace Manzadey\StreamTelecom\Tariff;

use Manzadey\StreamTelecom\Constants;

class Tariff
{
    private $sms;

    /**
     * Tariff constructor.
     *
     * @param array $array
     */
    public function __construct(array $array)
    {
        foreach ($array as $k => $item) {
            $this->$k = $item;
        }
    }

    /**
     * @return array
     */
    public function sms() : array
    {
        return array_intersect_key($this->sms, array_flip(Constants::PRICE_RUS));
    }

    /**
     * @return float
     */
    public function hlr() : float
    {
        return isset($this->hlr) ? array_shift(array_shift($this->hlr)) : 0;
    }

    /**
     * @return float
     */
    public function email() : float
    {
        return isset($this->email) ? array_shift(array_shift($this->email)) : 0;
    }

    /**
     * @return float
     */
    public function messenger() : float
    {
        return isset($this->messenger) ? array_shift(array_shift($this->messenger)) : 0;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return get_object_vars($this);
    }
}