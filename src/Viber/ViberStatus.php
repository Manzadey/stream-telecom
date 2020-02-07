<?php

namespace Manzadey\StreamTelecom\Viber;

use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\StreamTelecom;

class ViberStatus
{
    /**
     * ViberStatus constructor.
     *
     * @param StreamTelecom $streamTelecom
     * @param int           $messageId
     */
    public function __construct(StreamTelecom $streamTelecom, int $messageId)
    {
        $this->streamTelecom = $streamTelecom;
        $this->messageId     = $messageId;
    }

    public function get() : ViberStatusAnswer
    {
        $response              = $this->streamTelecom->request()->method('GET')->uri(Constants::URI_VIBER_STATUS)->data(get_object_vars($this))->main()->get();
        $response['messageId'] = $this->messageId;

        return new ViberStatusAnswer($response);
    }
}