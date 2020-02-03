<?php

namespace Manzadey\StreamTelecom\Sms;

use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\Support\Helpers;

class SmsStatusAnswer
{
    /**
     * @var string
     */
    protected $price;
    /**
     * @var string
     */
    protected $state;
    /**
     * @var string
     */
    protected $reporteddateutc;
    /**
     * @var string
     */
    protected $statedescription;

    /**
     * SmsStatusAnswer constructor.
     *
     * @param mixed $response
     */
    public function __construct(array $response)
    {
        foreach (array_change_key_case($response, CASE_LOWER) as $key => $item) {
            $this->$key = $item;
        }
    }

    /**
     * Статус сообщения
     *
     * @return mixed
     */
    public function getStateMessage()
    {
        return array_key_exists($this->state, Constants::MESSAGE_STATUSES) ? Constants::MESSAGE_STATUSES[$this->state] : $this->state;
    }

    /**
     * Дата доставки.
     *
     * @return string
     */
    public function getDateReported() : string
    {
        $time = preg_replace('/[^,.0-9]/', '', $this->reporteddateutc);
        $time = substr($time, 0, 10);
        return date('c', $time);
    }

    /**
     *  Цена за сообщение.
     *
     * @return float
     */
    public function getPrice() : float
    {
        return (float) $this->price;
    }
}
