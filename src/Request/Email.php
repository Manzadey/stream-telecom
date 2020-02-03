<?php

namespace Manzadey\StreamTelecom\Request;

class Email extends Construct
{
    public function get()
    {
        if (!$this->request->passwordPa) {
            throw new \RuntimeException('Установите пароль от личного кабинета для Email.');
        }

        $data['form_params'] = array_filter(array_merge($this->request->data, [
            'username' => $this->request->login,
            'password' => $this->request->passwordPa,
        ]));

        $response = $this->request->client->email()->request($this->request->method, $this->request->uri, $data)->getBody();

        return json_decode($response, true);
    }
}
