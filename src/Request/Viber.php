<?php

namespace Manzadey\StreamTelecom\Request;

class Viber extends Construct
{
    public function get()
    {
        if (!$this->request->sourceAddressIM) {
            throw new \RuntimeException('Установите Имя отправителя, зарегистрированное для Viber.');
        }

        !empty($this->request->data['textSMS']) ? $this->request->data['sourceAddressSMS'] = $this->request->sourceAddress : null;

        $data['form_params'] = array_filter(array_merge($this->request->data, [
            'login'           => $this->request->login,
            'pass'            => $this->request->password,
            'sourceAddressIM' => $this->request->sourceAddressIM,
        ]));

        dump($data, $this->request);

        $response = $this->request->client->rest()->request($this->request->method, $this->request->uri, $data)->getBody();

        return json_decode($response, true);
    }
}
