<?php

namespace Manzadey\StreamTelecom\Request;

class Main extends Construct
{
    /**
     * @return mixed
     */
    public function get()
    {
        $response = $this->request->client->rest()->request($this->request->method, $this->request->uri, $this->data())->getBody()->getContents();

        return json_decode($response, true);
    }

    /**
     * @return array
     */
    protected function data() : array
    {
        $this->request->method === 'GET' ? $query = 'query' : $query = 'form_params';

        $data[$query] = array_merge($this->request->data, [
            'sessionId'     => $this->request->sessionId,
            'sourceAddress' => $this->request->sourceAddress,
            'login'         => $this->request->login,
            'pass'          => $this->request->password,
        ]);

        return $data;
    }
}
