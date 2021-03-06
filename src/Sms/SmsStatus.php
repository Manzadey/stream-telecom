<?php

namespace Manzadey\StreamTelecom\Sms;

use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\Interfaces\ResponseInterface;
use Manzadey\StreamTelecom\StreamTelecom;

class SmsStatus implements ResponseInterface
{
    /**
     * @var int
     */
    private $messageId;
    /**
     * @var StreamTelecom
     */
    private $streamTelecom;

    /**
     * SmsStatus constructor.
     *
     * @param StreamTelecom $streamTelecom
     * @param int           $messageId
     */
    public function __construct(StreamTelecom $streamTelecom, int $messageId)
    {
        $this->streamTelecom = $streamTelecom;
        $this->messageId     = $messageId;
    }

    /**
     * @return SmsStatusAnswer
     */
    public function get() : SmsStatusAnswer
    {
        $response = $this->streamTelecom->request()->uri(Constants::URI_STATUS_MESSAGE)->data(get_object_vars($this))->main()->get();

        return new SmsStatusAnswer($response);
    }
}
