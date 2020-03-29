<?php

namespace Manzadey\StreamTelecom\Viber;

use Manzadey\StreamTelecom\Constants;

class ViberStatusAnswer
{
    /**
     * @var int|string|null 
     */
    public $delivery_method;
    /**
     * @var int
     */
    public $error;
    /**
     * @var string
     */
    public $state;
    /**
     * @var float
     */
    public $price;
    /**
     * @var string
     */
    public $state_time;
    /**
     * @var string
     */
    public $state_error;

    public function __construct(array $array)
    {
        $data = array_shift($array);

        $this->delivery_method = array_key_first($data);
        
        foreach ($data as $k => $value) {
            $this->$k = $value;
        }
    }

    public function getStateMessage() : string
    {
        return array_key_exists($this->state, Constants::VIBER_STATUSES) ? Constants::VIBER_STATUSES[$this->state] : $this->state;
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

    public function getStateTime()
    {
        return $this->state_time !== 'null' ? new \DateTime($this->state_time) : null;
    }

    public function getStateErrorMessage()
    {
        return array_key_exists($this->state_error, Constants::VIBER_ERRORS) ? Constants::VIBER_ERRORS[$this->state_error] : $this->state;
    }
}
