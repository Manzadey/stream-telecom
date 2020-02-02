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
    final public function request(string $uri, array $data = [], string $method = 'POST')
    {
        $method === 'GET' ? $query = 'query' : $query = 'form_params';

        $data[$query] = array_filter(array_merge($data, [
            'sessionId'     => $this->sessionId,
            'sourceAddress' => $this->sourceAddress,
            'login'         => $this->login,
            'pass'          => $this->password,
        ]));

        $response = $this->client()->rest()->request($method, $uri, $data)->getBody()->getContents();

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

        $data['form_params'] = array_filter(array_merge($data, [
            'username' => $this->login,
            'password' => $this->passwordPa,
        ]));

        $response = $this->client()->email()->request('POST', '', $data)->getBody();

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

        $data['json'] = array_filter(array_merge($data, [
            'login'   => $this->login,
            'pass'    => $this->password,
            'service' => $this->service,
        ]));

        $response = $this->client()->rest('json')->request('PUT', Constants::URI_VK_SEND, $data)->getBody();

        return json_decode($response, true);
    }

    final public function requestViber(string $uri, array $data)
    {
        if (!$this->sourceAddressIM) {
            throw new \RuntimeException('Установите Имя отправителя, зарегистрированное для Viber $c->setup()->viber("name")');
        }

        !empty($data['textSMS']) ? $data['sourceAddressSMS'] = $this->sourceAddress : null;

        $data['form_params'] = array_filter(array_merge($data, [
            'login'           => $this->login,
            'pass'            => $this->passwordPa,
            'sourceAddressIM' => $this->sourceAddressIM,
        ]));

        $response = $this->client()->rest()->request('POST', $uri, $data)->getBody();

        return json_decode($response, true);

    }
}
