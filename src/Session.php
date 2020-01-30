<?php

namespace Manzadey\StreamTelecom;

use GuzzleHttp\Client;

abstract class Session
{
    /**
     * @var string
     */
    public $login;
    /**
     * @var string
     */
    public $password;
    /**
     * @var string
     */
    protected $sourceAddress;
    /**
     * @var string
     */
    protected $sessionId;
    /**
     * Password from your personal account
     *
     * @var string
     */
    protected $passwordPa;
    /**
     * VK Service Name
     *
     * @var string
     */
    protected $service;
    /**
     * Viber Source Address
     *
     * @var string
     */
    protected $sourceAddressIM;

    /**
     * Session constructor.
     *
     * @param string $name
     * @param string $login
     * @param string $password
     */
    final public function __construct(string $name, string $login, string $password)
    {
        $this->sourceAddress = $name;
        $this->login         = $login;
        $this->password      = $password;

        $this->setup()->session();

    }

    /**
     * @return Setup
     */
    public function setup() : Setup
    {
        return new Setup($this);
    }

    /**
     * @param string $name
     *
     * @return Client
     */
    public function client(string $name) : Client
    {
        $client = new Client();

        if ($name === 'rest') {
            $client = new Client([
                'base_uri' => Constants::SERVER_REST,
                'headers'  => [
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
            ]);
        }

        if ($name === 'email') {
            $client = new Client([
                'headers' => [
                    'content-type' => 'application/x-www-form-urlencoded',
                ],
            ]);
        }

        if ($name === 'vk') {
            new Client([
                'headers' => [
                    'content-type' => 'application/json',
                ],
            ]);
        }

        return $client;
    }

    /**
     * @return string
     */
    public function getSessionId() : string
    {
        return $this->sessionId;
    }

    /**
     * @param string $service
     */
    public function setService(string $service) : void
    {
        $this->service = $service;
    }

    /**
     * @param string $sourceAddressIM
     */
    public function setSourceAddressIM(string $sourceAddressIM) : void
    {
        $this->sourceAddressIM = $sourceAddressIM;
    }

    /**
     * @param string $passwordPa
     */
    public function setPasswordPa(string $passwordPa) : void
    {
        $this->passwordPa = $passwordPa;
    }

    /**
     * @param string $sessionId
     */
    public function setSessionId(string $sessionId) : void
    {
        $this->sessionId = $sessionId;
    }
}
