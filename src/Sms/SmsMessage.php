<?php

namespace Manzadey\StreamTelecom\Sms;

use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\Protocol\StreamTelecom;

class SmsMessage
{
    /**
     * @var bool
     */
    public $created = false;

    /**
     * SmsMessage constructor.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        $response = array_change_key_case($response, CASE_LOWER);


        foreach ($response as $key => $item) {
            $this->$key = $item;
        }

        $this->checkMessageId();
    }

    /**
     * @return void
     */
    private function checkMessageId() : void
    {
        $message_id = Constants::MESSAGE_ID;

        if ($this->$message_id) {
            $this->created = true;
        }
    }

    /**
     * @return bool
     */
    public function isCreated() : bool
    {
        return $this->created;
    }
}