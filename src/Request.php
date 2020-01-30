<?php

namespace Manzadey\StreamTelecom;

abstract class Request extends Session
{
    /**
     * @param string $uri
     * @param array  $data
     *
     * @param string $method
     *
     * @return mixed
     */
    final public function request(string $uri, array $data, string $method = 'POST')
    {
        $query = 'form_params';

        if ($method === 'GET') {
            $query = 'query';
        }

        $data = array_filter(array_merge($data, [
            'sessionId'     => $this->sessionId,
            'sourceAddress' => $this->sourceAddress,
            'login'         => $this->login,
            'pass'          => $this->password,
        ]));

        $response = $this->client('rest')->request($method, $uri, [$query => $data])->getBody()->getContents();

        return json_decode($response, true);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    final public function requestEmail(array $data)
    {
        if (!$this->passwordPa) {
            throw new \RuntimeException('Установите пароль для Email! $c->setup()->email("password")');
        }

        $data = array_filter(array_merge($data, [
            'username' => $this->login,
            'password' => $this->passwordPa,
        ]));

        $response = $this->client('email')->request('POST', Constants::SERVER_EMAIL, ['form_params' => $data])->getBody();

        return json_decode($response, true);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    final public function requestVK(array $data)
    {
        if (!$this->service) {
            throw new \RuntimeException('Установите Идентификатор группы ВКонтакте! $c->setup()->vk("serviceName")');
        }

        $data = array_filter(array_merge($data, [
            'login'   => $this->login,
            'pass'    => $this->password,
            'service' => $this->service,
        ]));

        $response = $this->client('vk')->request('PUT', Constants::SERVER_VK, ['json' => $data])->getBody();

        return json_decode($response, true);
    }

    final public function requestViber(string $uri, array $data)
    {
        if (!$this->sourceAddressIM) {
            throw new \RuntimeException('Установите Имя отправителя, зарегистрированное для Viber $c->setup()->viber("name")');
        }

        if (!empty($data['textSMS'])) {
            $data['sourceAddressSMS'] = $this->sourceAddress;
        }

        $data = array_filter(array_merge($data, [
            'login'           => $this->login,
            'pass'            => $this->passwordPa,
            'sourceAddressIM' => $this->sourceAddressIM,
        ]));

        if (isset($data['phones'])) {
            foreach ($data['phones'] ad $item) {

            }
        }

        dd($data);

        $response = $this->client('rest')->request('POST', $uri, ['form_params' => $data])->getBody();

        return json_decode($response, true);

    }
}