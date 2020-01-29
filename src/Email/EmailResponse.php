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
        if ($this->data !== null) {
            $this->success = true;
        }
    }

    /**
     * @return string|null
     */
    public function getResponseMessage()
    {
        return $this->msg['text'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getErrorCode()
    {
        return $this->msg['err_code'] ?? null;
    }

    /**
     * @return string|null
     */
    public function getMessageType()
    {
        return $this->msg['type'] ?? null;
    }
}