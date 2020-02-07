<?php

namespace Manzadey\StreamTelecom\Request;

class Viber extends Construct
{
    /**
     * @return mixed
     */
    public function get()
    {
        $this->validated();

        dd($this->data());
        
        $response = $this->request->client->rest()->request($this->request->method, $this->request->uri, $this->data())->getBody();

        return json_decode($response, true);
    }

    /**
     * @return array
     */
    protected function data() : array
    {
        $data['form_params'] = array_merge($this->request->data, [
            'login'           => $this->request->login,
            'pass'            => $this->request->password,
            'sourceAddressIM' => $this->request->sourceAddressIM,
        ]);

        if (isset($data['form_params']['phones'])) {
            foreach($data['form_params']['phones'] as $k => $phone) {
                !empty($phone['textSMS']) ? $data['form_params']['phones'][$k]['sourceAddressSMS'] = $this->request->sourceAddress : null;
            }
        }

        if (!empty($data['form_params']['textSMS'])) {
            $data['form_params']['sourceAddressSMS'] = $this->request->sourceAddress;
        }

        return $data;
    }

    protected function validated() : void
    {
        if (empty($this->request->sourceAddressIM)) {
            throw new \RuntimeException('Установите Имя отправителя, зарегистрированное для Viber.');
        }
    }
}
