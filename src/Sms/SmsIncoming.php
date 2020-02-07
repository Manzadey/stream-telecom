<?php

namespace Manzadey\StreamTelecom\Sms;

use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\StreamTelecom;
use Manzadey\StreamTelecom\Support\Helpers;

class SmsIncoming
{
    /**
     * @var string
     */
    private $minDateUTC;
    /**
     * @var string
     */
    private $maxDateUTC;
    /**
     * @var StreamTelecom
     */
    private $streamTelecom;

    /**
     * SmsIncoming constructor.
     *
     * @param StreamTelecom $streamTelecom
     */
    public function __construct(StreamTelecom $streamTelecom)
    {
        $this->streamTelecom = $streamTelecom;
    }

    /**
     * Минимальное значение периода за который происходит выборка входящих сообщений
     *
     * @param string $start
     *
     * @return SmsIncoming
     * @throws \Exception
     */
    public function start(string $start) : self
    {
        $this->minDateUTC = Helpers::dateFormatToUtc($start);

        return $this;
    }

    /**
     * Максимальное значение периода за который происходит выборка входящих сообщений
     *
     * @param string $end
     *
     * @return SmsIncoming
     * @throws \Exception
     */
    public function end(string $end) : self
    {
        $this->maxDateUTC = Helpers::dateFormatToUtc($end);

        return $this;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $this->validated();

        return $this->streamTelecom->request()->uri(Constants::URI_SMS_INCOMING)->data(get_object_vars($this))->method('GET')->main()->get();
    }

    protected function validated() : void
    {
        if ($this->minDateUTC === null) {
            throw new \InvalidArgumentException('Укажите минимальное значение периода за который происходит выборка входящих сообщений!');
        }

        if ($this->maxDateUTC === null) {
            throw new \InvalidArgumentException('Укажите максимальное значение периода за который происходит выборка входящих сообщений!');
        }
    }
}
