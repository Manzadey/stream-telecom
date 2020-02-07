<?php

namespace Manzadey\StreamTelecom\Request;

use Manzadey\StreamTelecom\Client;

final class Request
{
    /**
     * @var string
     */
    public $method = 'POST';
    /**
     * @var string
     */
    public $uri = '';
    /**
     * @var array
     */
    public $data = [];
    /**
     * @var Client
     */
    public $client;
    /**
     * @var string
     */
    public $passwordPa;
    /**
     * @var string
     */
    public $login;
    /**
     * @var string
     */
    public $sessionId;
    /**
     * @var string
     */
    public $sourceAddress;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    public $sourceAddressIM;
    /**
     * @var string
     */
    public $service;

    /**
     * Request constructor.
     *
     * @param array  $array
     * @param Client $client
     */
    public function __construct(array $array, Client $client)
    {
        $this->client = $client;

        foreach($array as $k => $item) {
            $this->$k = $item;
        }
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function method(string $method) : self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param string $uri
     *
     * @return Request
     */
    public function uri(string $uri) : self
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * @param array $data
     *
     * @return Request
     */
    public function data(array $data) : self
    {
        if (isset($data['streamTelecom'])) {
            unset($data['streamTelecom']);
        }

        $this->data = array_filter($data);

        return $this;
    }

    /**
     * @return Main
     */
    public function main() : Main
    {
        return new Main($this);
    }

    /**
     * @return Viber
     */
    public function viber() : Viber
    {
        return new Viber($this);
    }

    /**
     * @return VK
     */
    public function vk() : VK
    {
        return new VK($this);
    }

    /**
     * @return Email
     */
    public function email() : Email
    {
        return new Email($this);
    }
}
