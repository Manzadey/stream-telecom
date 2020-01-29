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
        $data = array_filter(array_merge($data, [
            'login'   => $this->login,
            'pass'    => $this->password,
            'service' => $this->vkId,
        ]));

        $response = $this->client('vk')->request('PUT', Constants::SERVER_VK, ['json' => $data])->getBody();

        return json_decode($response, true);
    }
}