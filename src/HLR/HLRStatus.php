<?php

namespace Manzadey\StreamTelecom\HLR;

class HLRStatus
{
    /**
     *  Статус HLR-запроса
     *
     * @var int
     */
    private $state;
    /**
     * Международный идентификатор мобильного абонента (индивидуальный номер абонента).
     *
     * @var string
     */
    private $imsi;
    /**
     * Признак портированности номера. В случае портированности - 1, иначе - 0.
     *
     * @var int
     */
    private $port;
    /**
     * Код коммутатора, обслуживающего абонента.
     *
     * @var string
     */
    private $msc;
    /**
     * Код ошибки
     *
     * @var string
     */
    private $error;
    /**
     * Идентификатор HLR-запроса
     *
     * @var int
     */
    private $messageid;

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
        $msg    = 'Неизвестно';
        $states = [
            -1 => 'Номер находится в процессе проверки',
            0  => 'Абонент доступен',
            42 => 'Абонент недоступен',
        ];

        array_key_exists($this->state, $states) ? $msg = $states[$this->state] : null;

        return $msg;
    }

    /**
     * Провайдер пользователя
     *
     * @return string
     */
    public function getProvider() : string
    {
        $msg = 'Неизвестно';
        $providers = [
            25099 => 'Beeline',
        ];

        array_key_exists($this->imsi, $providers) ? $msg = $providers[$this->imsi] : null;

        return $msg;
    }
}
