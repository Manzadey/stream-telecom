<?php

namespace Manzadey\StreamTelecom\Request;

class VK extends Construct
{
    /**
     * @return mixed
     */
    public function get()
    {
        $this->validated();

        dump($this->data());

        dd($this);

        $response = $this->request->client->rest('json')->request($this->request->method, $this->request->uri, $this->data())->getBody();

        return json_decode($response, true);
    }

    /**
     * @return array
     */
    protected function data() : array
    {
        $data['json'] = array_merge($this->request->data, [
            'login'   => $this->request->login,
            'pass'    => $this->request->password,
            'service' => $this->request->service,
        ]);

        !empty($data['json']['extra_param']['viber']) ? $data['json']['extra_param']['viber']['sourceAddressIM'] = $this->request->sourceAddressIM : null;
        !empty($data['json']['extra_param']['sms']) ? $data['json']['extra_param']['sms']['sourceAddressSMS'] = $this->request->sourceAddress : null;

        return $data;
    }

    protected function validated() : void
    {
        if (empty($this->request->service)) {
            throw new \RuntimeException('Установите Идентификатор группы ВКонтакте.');
        }
    }
}
