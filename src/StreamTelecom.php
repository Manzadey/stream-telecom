<?php

namespace Manzadey\StreamTelecom;

use Manzadey\StreamTelecom\Email\Email;
use Manzadey\StreamTelecom\HLR\HLR;
use Manzadey\StreamTelecom\Sms\Sms;
use Manzadey\StreamTelecom\Statistic\Statistic;
use Manzadey\StreamTelecom\VK\VK;
use Manzadey\StreamTelecom\Viber\Viber;

class StreamTelecom extends Request
{
    /**
     * @return float
     */
    public function balance() : float
    {
        return (float) $this->request(Constants::URI_BALANCE, []);
    }

    /**
     * @return array
     */
    public function tariffs() : array
    {
        return $this->request(Constants::URI_TARIFFS, []);
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
