<?php

namespace Manzadey\StreamTelecom\Request;

class Main extends Construct
{
    public function get()
    {
        $this->request->method === 'GET' ? $query = 'query' : $query = 'form_params';

        $data[$query] = array_filter(array_merge($this->request->data, [
            'sessionId'     => $this->request->sessionId,
            'sourceAddress' => $this->request->sourceAddress,
            'login'         => $this->request->login,
            'pass'          => $this->request->password,
        ]));

        $response = $this->request->client->rest()->request($this->request->method, $this->request->uri, $data)->getBody()->getContents();

        return json_decode($response, true);
    }
}
