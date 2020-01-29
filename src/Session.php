<?php

namespace Manzadey\StreamTelecom;

use GuzzleHttp\Client;

abstract class Session
{
    /**
     * @var string
     */
    protected $login;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var string
     */
    protected $sourceAddress;
    /**
     * @var string
     */
    protected $sessionId = '';
    /**
     * @var string
     */
    protected $vkId;
    /**
     * @var string
     */
    protected $passwordPa;

    /**
     * Session constructor.
     *
     * @param string $name
     * @param string $login
     * @param string $password
     * @param string $passwordPa
     * @param string $vkId
     */
    final public function __construct(string $name, string $login, string $password, string $passwordPa = '', string $vkId = '')
    {
        $this->sourceAddress = $name;
        $this->login         = $login;
        $this->password      = $password;
        $this->passwordPa   = $passwordPa;
        $this->vkId         = $vkId;

        $this->setupSession();

    }

    /**
     * @return void
     */
    private function setupSession() : void
    {
        $response = $this->client('rest')->request('POST', 'Session/', [
            'form_params' => [
                'login'    => $this->login,
                'password' => $this->password,
            ],
        ]);

        $this->sessionId = json_decode($response->getBody(), true);
    }

    /**
     * @param string $name
     *
     * @return Client
     */
    protected function client(string $name) : Client
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
}
