<?php

namespace Manzadey\StreamTelecom\Request;

class VK extends Construct
{
    public function get()
    {
        if (!$this->request->service) {
            throw new \RuntimeException('Установите Идентификатор группы ВКонтакте.');
        }

        $data['json'] = array_filter(array_merge($this->request->data, [
            'login'   => $this->request->login,
            'pass'    => $this->request->password,
            'service' => $this->request->service,
        ]));

        $response = $this->request->client->rest('json')->request($this->request->method, $this->request->uri, $data)->getBody();

        return json_decode($response, true);
    }
}
