<?php

namespace Manzadey\StreamTelecom;

use Manzadey\StreamTelecom\Request\Request;

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
    protected $sourceAddressIM = Constants::VIBER_SOURCE;

    /**
     * @var string
     */
    protected $errorMsg;

    /**
     * Session constructor.
     *
     * @param string $name
     * @param string $login
     * @param string $password
     *
     * @throws \Exception
     */
    final public function __construct(string $name, string $login, string $password)
    {
        $this->sourceAddress = $name;
        $this->login         = $login;
        $this->password      = $password;

        $this->setup()->session();

        /*

        if (!$this->sessionId) {
            throw new \RuntimeException('Ошибка установки соединения с Stream Telecom. ' . $this->errorMsg, 1);
        }

        */
    }

    /**
     * @return Setup
     */
    public function setup() : Setup
    {
        return new Setup($this);
    }

    /**
     * @return Client
     */
    public function client() : Client
    {
        return new Client();
    }

    /**
     * @return Request
     */
    public function request() : Request
    {
        return new Request(array_filter(get_object_vars($this)), $this->client());
    }

    /**
     * @return string
     */
    public function getSessionId() : string
    {
        return $this->sessionId;
    }

    /**
     * @return bool 
     */
    public function sessionExists() : bool
    {
        return $this->sessionId !== '';
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

    /**
     * @param string $errorMsg
     */
    public function setErrorMsg(string $errorMsg) : void
    {
        $this->errorMsg = $errorMsg;
    }

    /**
     * @return string
     */
    public function getErrorMsg() : string
    {
        return $this->errorMsg ?? '';
    }

    /**
     * @return bool
     */
    public function hasErrorMsg() : bool
    {
        return !empty($this->errorMsg) ? true : false;
    }
}
