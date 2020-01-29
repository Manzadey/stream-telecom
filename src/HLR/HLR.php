<?php

namespace Manzadey\StreamTelecom\HLR;

use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\Interfaces\ResponseInterface;
use Manzadey\StreamTelecom\StreamTelecom;

class HLR implements ResponseInterface
{
    /**
     * @var int
     */
    private $messageId;
    /**
     * @var int
     */
    private $phone;
    /**
     * @var StreamTelecom
     */
    private $streamTelecom;

    /**
     * HLR constructor.
     *
     * @param StreamTelecom $streamTelecom
     */
    public function __construct(StreamTelecom $streamTelecom)
    {
        $this->streamTelecom = $streamTelecom;
    }

    /**
     * Номер телефона для проверки
     *
     * @param int $phone
     *
     * @return $this
     */
    public function phone(int $phone) : self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return $this
     */
    public function get() : self
    {
        if ($this->phone === null) {
            throw new \InvalidArgumentException('Укажите номер телефона! ');
        }

        $response = $this->streamTelecom->request(Constants::URI_SEND_HLR, ['destinationAddress' => $this->phone]);

        $this->messageId = (int) $response[0];

        return $this;

    }

    /**
     * @param int $messageId
     *
     * @return HLRStatus
     */
    public function status(int $messageId = 0) : HLRStatus
    {
        $this->messageId = $messageId ?? $this->messageId;

        $response = $this->streamTelecom->request(Constants::URI_STATE_HLR, get_object_vars($this), 'GET');
        $response['messageId'] = $this->messageId;

        return new HLRStatus($response);
    }
}
