<?php

namespace Manzadey\StreamTelecom\Email;

use Manzadey\StreamTelecom\StreamTelecom;

class Email
{
    /**
     * @var StreamTelecom
     */
    public $streamTelecom;

    /**
     * Email constructor.
     *
     * @param StreamTelecom $streamTelecom
     */
    public function __construct(StreamTelecom $streamTelecom)
    {
        $this->streamTelecom = $streamTelecom;
    }

    /**
     * @return Lists
     */
    public function lists() : Lists
    {
        return new Lists($this->streamTelecom);
    }

    /**
     * @return Campaigns
     */
    public function campanings() : Campaigns
    {
        return new Campaigns($this->streamTelecom);
    }

    /**
     * @return Reports
     */
    public function reports() : Reports
    {
        return new Reports($this->streamTelecom);
    }
}
