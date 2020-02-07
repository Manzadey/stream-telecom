<?php

namespace Manzadey\StreamTelecom\Sms;


use Manzadey\StreamTelecom\StreamTelecom;

class Sms
{
    /**
     * @var StreamTelecom
     */
    private $streamTelecom;

    /**
     * Sms constructor.
     *
     * @param StreamTelecom $streamTelecom
     */
    public function __construct(StreamTelecom $streamTelecom)
    {
        $this->streamTelecom = $streamTelecom;
    }

    /**
     * @return SmsSend
     */
    public function send() : SmsSend
    {
        return new SmsSend($this->streamTelecom);
    }

    /**
     * @param int $messageId
     *
     * @return SmsStatus
     */
    public function status(int $messageId) : SmsStatus
    {
        return new SmsStatus($this->streamTelecom, $messageId);
    }

    /**
     * @return SmsIncoming
     */
    public function incoming() : SmsIncoming
    {
        return new SmsIncoming($this->streamTelecom);
    }
}