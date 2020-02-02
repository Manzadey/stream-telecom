<?php

namespace Manzadey\StreamTelecom;

final class Setup
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
        try {
            $response = $this->session->client()->rest()->request('POST', Constants::URI_SESSION, [
                'form_params' => [
                    'login'    => $this->session->login,
                    'password' => $this->session->password,
                ],
            ]);

            $sessionId = json_decode($response->getBody(), true);

            $this->session->setSessionId($sessionId);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $this->session->setErrorMsg($e->getMessage());
            $this->session->setSessionId('');
        }
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
