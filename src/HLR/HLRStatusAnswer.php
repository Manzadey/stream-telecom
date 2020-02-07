<?php

namespace Manzadey\StreamTelecom\HLR;

use Manzadey\StreamTelecom\Constants;

class HLRStatusAnswer
{
    /**
     *  Статус HLR-запроса
     *
     * @var int
     */
    public $state;
    /**
     * Международный идентификатор мобильного абонента (индивидуальный номер абонента).
     *
     * @var string
     */
    public $imsi;
    /**
     * Признак портированности номера. В случае портированности - 1, иначе - 0.
     *
     * @var int
     */
    public $port;
    /**
     * Код коммутатора, обслуживающего абонента.
     *
     * @var string
     */
    public $msc;
    /**
     * Код ошибки
     *
     * @var string
     */
    public $error;
    /**
     * Идентификатор HLR-запроса
     *
     * @var int
     */
    public $messageid;

    /**
     * HLRStatus constructor.
     *
     * @param $array
     */
    public function __construct($array)
    {
        foreach (array_change_key_case($array, CASE_LOWER) as $key => $item) {
            $this->$key = $item;
        }
    }

    /**
     * Текстовый статус HLR-запроса
     *
     * @return string
     */
    public function getState() : string
    {
        return array_key_exists($this->state, Constants::HLR_STATUSES) ? Constants::HLR_STATUSES[$this->state] : 'Неизвестно';
    }

    /**
     * @return null
     */
    public function getPorting()
    {
        return $this->port !== null ? (bool) $this->port : null;
    }

    /**
     * @return string
     */
    public function getError() : string
    {
        return array_key_exists($this->error, Constants::HLR_ERRORS) ? Constants::HLR_ERRORS[$this->error] : 'Неизвестно';
    }
}
