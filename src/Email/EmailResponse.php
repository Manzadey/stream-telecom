<?php

namespace Manzadey\StreamTelecom\Email;

class EmailResponse
{
    protected $success = false;
    protected $msg;
    protected $data;

    /**
     * EmailResponse constructor.
     *
     * @param array $response
     */
    public function __construct(array $response)
    {
        foreach ($response['response'] as $key => $item) {
            $this->$key = $item;
        }

        $this->isChecked();
    }

    private function isChecked() : void
    {
        $this->data !== null ? $this->success = true : null;
    }

    /**
     * @return string
     */
    public function getResponseMessage()
    {
        return $this->msg['text'] ?? '';
    }

    /**
     * @return string
     */
    public function getErrorCode()
    {
        return $this->msg['err_code'] ?? '';
    }

    /**
     * @return string
     */
    public function getMessageType()
    {
        return $this->msg['type'] ?? '';
    }
}
