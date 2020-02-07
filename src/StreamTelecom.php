<?php

namespace Manzadey\StreamTelecom;

use Manzadey\StreamTelecom\Email\Email;
use Manzadey\StreamTelecom\HLR\HLR;
use Manzadey\StreamTelecom\Sms\Sms;
use Manzadey\StreamTelecom\Statistic\Statistic;
use Manzadey\StreamTelecom\Tariff\Tariff;
use Manzadey\StreamTelecom\VK\VK;
use Manzadey\StreamTelecom\Viber\Viber;

class StreamTelecom extends Session
{
    /**
     * @return float
     */
    public function balance() : float
    {
        return (float) $this->request()->uri(Constants::URI_BALANCE)->main()->get();
    }

    /**
     * @return Tariff
     */
    public function tariffs() : Tariff
    {
        $response = $this->request()->uri(Constants::URI_TARIFFS)->main()->get();
        return new Tariff($response);
    }

    /**
     * @return Statistic
     */
    public function statistic() : Statistic
    {
        return new Statistic($this);
    }

    /**
     * @return HLR
     */
    public function hlr() : HLR
    {
        return new HLR($this);
    }

    /**
     * @return Sms
     */
    public function sms() : Sms
    {
        return new Sms($this);
    }

    /**
     * @return Email
     */
    public function email() : Email
    {
        return new Email($this);
    }

    /**
     * @return VK
     */
    public function vk() : VK
    {
        return new VK($this);
    }

    /**
     * @return Viber
     */
    public function viber() : Viber
    {
        return new Viber($this);
    }
}
