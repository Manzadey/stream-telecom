<?php

namespace Manzadey\StreamTelecom\Email;

use Manzadey\StreamTelecom\StreamTelecom;
use Manzadey\StreamTelecom\Constants;

abstract class Job
{
    /**
     * @var int 
     */
    protected $method_exists;
    /**
     * @var StreamTelecom 
     */
    protected $streamTelecom;
    /**
     * @var int
     */
    protected $list_id;
    /**
     * @var int
     */
    protected $campaning_id;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var int
     */
    protected $limit;
    /**
     * @var int
     */
    protected $member_id;
    /**
     * @var string
     */
    protected $order;
    /**
     * @var string
     */
    protected $type;
    /**
     * @var string
     */
    protected $start;

    /**
     * Job constructor.
     *
     * @param StreamTelecom $streamTelecom
     */
    final public function __construct(StreamTelecom $streamTelecom)
    {
        $this->streamTelecom = $streamTelecom;
        $this->method_exists = strlen($this->method);
    }

    /**
     * @param string $method
     *
     * @return $this
     */
    public function method(string $method) : self
    {
        $this->method .= $method;

        return $this;
    }

    /**
     * @param int $list_id
     *
     * @return $this
     */
    public function listId(int $list_id) : self
    {
        $this->list_id = $list_id;

        return $this;
    }

    /**
     * @param int $campaning_id
     *
     * @return $this
     */
    public function campaningId(int $campaning_id) : self
    {
        $this->campaning_id = $campaning_id;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function name(string $name) : self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $limit
     *
     * @return $this
     */
    public function limit(int $limit) : self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param string $type
     *
     * @return $this
     */
    public function type(string $type) : self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param int $member_id
     *
     * @return $this
     */
    public function memberId(int $member_id) : self
    {
        $this->member_id = $member_id;

        return $this;
    }

    /**
     * @param string $order
     *
     * @return $this
     */
    public function order(string $order) : self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @param string $start
     *
     * @return $this
     */
    public function start(string $start) : self
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function get()
    {
        if (strlen($this->method) === $this->method_exists) {
            throw new \RuntimeException('Укажите метод!');
        }

        if (!in_array($this->method, Constants::EMAIL_METHODS, true)) {
            throw new \RuntimeException('Неизвестный метод');
        }

        $data = array_merge(get_object_vars($this), ['method' => $this->method]);
        $data = array_filter($data);

        $response = $this->streamTelecom->requestEmail($data);

        return new EmailResponse($response);
    }
}
