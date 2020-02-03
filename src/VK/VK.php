<?php

namespace Manzadey\StreamTelecom\VK;

use Manzadey\StreamTelecom\StreamTelecom;
use Manzadey\StreamTelecom\Support\Helpers;
use Manzadey\StreamTelecom\Constants;

class VK
{
    private static $count_package = 0;
    /**
     * @var StreamTelecom
     */
    private $streamTelecom;
    /**
     * @var int
     */
    private $id_tmpl;
    /**
     * @var array
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
    private $phones_package;
    /**
     * @var string
     */
    private $text;
    /**
     * @var array
     */
    private $cascade;

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
    private function idTmpl(int $id_tmpl) : self
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
    private function tmplData(array $tmpl_data) : self
    {
        $this->tmpl_data = $tmpl_data;

        return $this;
    }

    /**
     * @param int   $id_tmpl
     * @param array $tmpl_data
     *
     * @return $this
     */
    public function template(int $id_tmpl, array  $tmpl_data) : self
    {
        $this->idTmpl($id_tmpl);
        $this->tmplData($tmpl_data);

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
     * @param string $phone
     *
     * @return $this
     */
    public function to(string $phone) : self
    {
        $this->phones = json_encode([1 => ['phone' => $phone]]);

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
     * Запрос статуса сообщения VK
     *
     * @param array $ids
     *
     * @return $this
     */
    public function status(array $ids) : self
    {
        $ids = array_map('intval', $ids);
        $ids = array_filter($ids);

        $this->id     = implode(',', $ids);
        $this->action = 'get_status';

        return $this;
    }

    /**
     * Запрос списка Сервисов
     *
     * @return $this
     */
    public function services() : self
    {
        $this->action = 'get_service';

        return $this;
    }

    /**
     * Запрос списка Шаблонов
     *
     * @return $this
     */
    public function templates() : self
    {
        $this->action = 'get_tmpl';

        return $this;
    }

    /**
     * @param \Closure $closure
     *
     * @return $this
     */
    public function package(\Closure $closure) : self
    {
        $fields = [
            'id_tmpl',
            'tmpl_data',
            'ttl',
            'phones',
        ];

        $get_data = get_object_vars($closure($this));

        $attributes = array_filter($get_data, static function ($a) use ($fields) {
            return in_array($a, $fields, true);
        }, ARRAY_FILTER_USE_KEY);

        $this->phones_package[self::$count_package++] = $attributes;

        foreach (array_keys($attributes) as $attribute) {
            unset($this->$attribute);
        }

        return $this;
    }

    /**
     * @param array         $providers
     * @param \Closure|null $closure
     *
     * @return VK
     */
    public function cascade(array $providers = ['viber', 'sms'], \Closure $closure = null) : self
    {
        $this->cascade = $providers;

        if (is_object($closure) && $closure instanceof \Closure) {
            
        }

        $this->id = implode(',', array_map('intval', $ids));

        return $this;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        if ($this->phones_package) {
            $this->phones = $this->phones_package;
            unset($this->phones_package);
        }

        if ($this->cascade) {
            $this->extraParamGenerated();
        }

        return $this->streamTelecom->requestVK(array_filter(get_object_vars($this)));
    }

    /**
     * @return void
     */
    private function extraParamGenerated() : void
    {
        $this->templates();

        $data      = array_filter(get_object_vars($this));
        dump($data);
        $templates = $this->streamTelecom->requestVK($data);

        dump($templates);

        $id_template = Helpers::recursive_array_search($this->id_tmpl, $templates);

        if ($id_template === false) {
            throw new \RuntimeException('Не найден ID шаблона.');
        }

        $template = $templates[$id_template]['tmpl'];

        $search_data = array_flip($this->tmpl_data);
        $search_data = array_map(static function ($s) {
            return '#' . $s . '#';
        }, $search_data);
        $search_data = array_flip($search_data);

        $message = str_replace(array_keys($search_data), array_values($data), $template);

        $extra_params = [
            'viber' => ['textIM' => $message],
            'sms'   => ['textSMS' => $message],
        ];

        $this->extra_param = $extra_params;

        return $this->streamTelecom->request()->data(get_object_vars($this))->method('PUT')->uri(Constants::URI_VK_SEND)->vk()->get();
    }
}
