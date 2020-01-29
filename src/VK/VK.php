<?php

namespace Manzadey\StreamTelecom\VK;

use Manzadey\StreamTelecom\StreamTelecom;

class VK
{
    /**
     * @var StreamTelecom
     */
    private $streamTelecom;
    /**
     * @var int
     */
    private $id_tmpl;
    /**
     * @var string
     */
    private $tmpl_data;
    /**
     * @var int
     */
    private $ttl;
    /**
     * @var false|string
     */
    private $phones;
    /**
     * @var false|string
     */
    private $extra_param;
    /**
     * @var string
     */
    private $action;
    /**
     * @var string
     */
    private $id;

    /**
     * VK constructor.
     *
     * @param StreamTelecom $streamTelecom
     */
    public function __construct(StreamTelecom $streamTelecom)
    {
        $this->streamTelecom = $streamTelecom;
    }

    /**
     *  Идентификатор шаблона
     *
     * @param int $id_tmpl
     *
     * @return $this
     */
    public function idTmpl(int $id_tmpl) : self
    {
        $this->id_tmpl = $id_tmpl;

        return $this;
    }

    /**
     * JSON объект, где ключи имена переменных в шаблоне
     *
     * @param array $tmpl_data
     *
     * @return $this
     */
    public function tmplData(array $tmpl_data) : self
    {
        $this->tmpl_data = json_encode($tmpl_data);

        return $this;
    }

    /**
     * время жизни сообщения в секундах (по умолчанию 7200)
     *
     * @param int $ttl
     *
     * @return $this
     */
    public function ttl(int $ttl) : self
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * Список номеров телефонов получателей
     *
     * @param array $phones
     *
     * @return $this
     */
    public function phones(array $phones) : self
    {
        $this->phones = json_encode($phones);

        return $this;
    }

    /**
     * Дополнительные данные, которые вводятся для отправки viber или смс в случае недоставки сообщения ВКонтакте
     *
     * @param array $extra_param
     *
     * @return $this
     */
    public function extraParam(array $extra_param) : self
    {
        $this->extra_param = json_encode($extra_param);

        return $this;
    }

    /**
     * Совершаемое действие
     *
     * @param string $action
     *
     * @return $this
     */
    public function action(string $action) : self
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Идентификатор сообщения
     *
     * @param array $ids
     *
     * @return $this
     */
    public function id(array $ids) : self
    {
        $this->id = implode(',', $ids);

        return $this;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->streamTelecom->requestVK(get_object_vars($this));
    }
}
