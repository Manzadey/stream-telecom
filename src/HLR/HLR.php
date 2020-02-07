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
     * @return int
     */
    public function get() : int
    {
        if ($this->phone === null) {
            throw new \InvalidArgumentException('Укажите номер телефона!');
        }

        $response = $this->streamTelecom->request()->uri(Constants::URI_SEND_HLR)->data(['destinationAddress' => $this->phone])->main()->get();

        return (int) $response[0];

    }

    /**
     * @param int $messageId
     *
     * @return HLRStatus
     */
    public function status(int $messageId) : HLRStatus
    {
        return new HLRStatus($this->streamTelecom, $messageId);
    }
}
