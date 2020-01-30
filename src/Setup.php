<?php

namespace Manzadey\StreamTelecom;

class Setup
{
    /**
     * @var Session
     */
    private $session;

    /**
     * Setup constructor.
     *
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function session() : void
    {
        $response = $this->session->client('rest')->request('POST', 'Session/', [
            'form_params' => [
                'login'    => $this->session->login,
                'password' => $this->session->password,
            ],
        ]);

        $sessionId = json_decode($response->getBody(), true);

        $this->session->setSessionId($sessionId);
    }

    /**
     * @param string $service
     */
    public function vk(string $service) : void
    {
        $this->session->setService($service);
    }

    /**
     * @param string $password
     */
    public function email(string $password) : void
    {
        $this->session->setPasswordPa($password);
    }

    /**
     * @param string $sourceAddressIM
     */
    public function viber(string $sourceAddressIM) : void
    {
        $this->session->setSourceAddressIM($sourceAddressIM);
    }
}