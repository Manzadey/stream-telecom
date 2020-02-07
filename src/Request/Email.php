<?php

namespace Manzadey\StreamTelecom\Request;

class Email extends Construct
{
    /**
     * @return mixed
     */
    public function get()
    {
        $this->validated();
        
        $response = $this->request->client->email()->request($this->request->method, $this->request->uri, $this->data())->getBody();

        return json_decode($response, true);
    }

    /**
     * @return array
     */
    protected function data() : array
    {
        $data['form_params'] = array_merge($this->request->data, [
            'username' => $this->request->login,
            'password' => $this->request->passwordPa
        ]);

        return $data;
    }

    protected function validated() : void
    {
        if (empty($this->request->passwordPa)) {
            throw new \RuntimeException('Установите пароль от личного кабинета для Email.');
        }

    }
}
