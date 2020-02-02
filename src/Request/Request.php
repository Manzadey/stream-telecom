<?php

namespace Manzadey\StreamTelecom\Request;

use Manzadey\StreamTelecom\Client;

final class Request
{
    public $method = 'POST';
    public $uri = '';
    public $data = [];

    public function __construct(array $array, Client $client)
    {
        $this->client = $client;
        foreach($array as $k => $item) {
            $this->$k = $item;
        }
    }

    public function method($method)
    {
        $this->method = $method;

        return $this;
    }

    public function uri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    public function data(array $data)
    {
        $this->data = $data;

        return $this;
    }

    public function main()
    {
        return new Main($this);
    }

    public function viber()
    {
        return new Viber($this);
    }

    public function vk()
    {
        return new VK($this);
    }

    public function email()
    {
        return new Email($this);
    }
}
