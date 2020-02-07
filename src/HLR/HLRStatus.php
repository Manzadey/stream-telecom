<?php

namespace Manzadey\StreamTelecom\HLR;

use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\StreamTelecom;

class HLRStatus
{
    /**
     * @var StreamTelecom
     */
    private $streamTelecom;
    /**
     * @var int
     */
    private $messageId;

    /**
     * HLRStatus constructor.
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
     * @return HLRStatusAnswer
     */
    public function get() : HLRStatusAnswer
    {
        $response              = $this->streamTelecom->request()->method('GET')->uri(Constants::URI_STATE_HLR)->data(get_object_vars($this))->main()->get();
        $response['messageId'] = $this->messageId;

        return new HLRStatusAnswer($response);
    }
}