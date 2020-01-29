<?php

namespace Manzadey\StreamTelecom\Sms;

use Manzadey\StreamTelecom\Constants;

class SmsResponse
{
    /**
     * @var SmsSend
     */
    private $smsSend;

    /**
     * SmsResponse constructor.
     *
     * @param SmsSend $smsSend
     */
    public function __construct(SmsSend $smsSend)
    {
        $this->smsSend = $smsSend;
    }

    /**
     * @return array
     */
    public function processingResponse() : array
    {
        $messages = [];

        if ($this->smsSend->query_uri === Constants::QUERY_SIMPLE['uri']) {
            if (isset($this->smsSend->response[0])) {
                $messages[] = new SmsMessage([Constants::MESSAGE_ID => $this->smsSend->response[0]]);
            } else {
                $messages[] = new SmsMessage((array) $this->smsSend->response);
            }
        }

        if ($this->smsSend->query_uri === Constants::QUERY_MULTIPLE['uri']) {
            foreach ($this->smsSend->response as $item) {

                if (isset($item[0])) {
                    $messages[] = new SmsMessage([Constants::MESSAGE_ID => $item[0]]);
                } else {
                    $messages[] = new SmsMessage($item);
                }
            }
        }
        
        if ($this->smsSend->query_uri === Constants::QUERY_MULTIPLE_PACKET) {
            foreach ($this->smsSend->response as $item) {
                if (is_int($item)) {
                    $messages[] = new SmsMessage([Constants::MESSAGE_ID => $this->smsSend->response[0]]);
                }

                if (is_array($item)) {
                    $messages[] = new SmsMessage($item);
                }
            }
        }

        return $messages;
    }
}