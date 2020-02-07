<?php

namespace Manzadey\StreamTelecom\VK;

use Closure;
use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\StreamTelecom;
use Manzadey\StreamTelecom\Support\Helpers;

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
     * @var array
     */
    private $extra_param = [];
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
     * @param int $id_tmpl Идентификатор шаблона
     *
     * @return $this
     */
    protected function idTmpl(int $id_tmpl) : self
    {
        $this->id_tmpl = $id_tmpl;

        return $this;
    }

    /**
     * @param array $tmpl_data JSON объект, где ключи имена переменных в шаблоне
     *
     * @return $this
     */
    protected function tmplData(array $tmpl_data) : self
    {
        $this->tmpl_data = $tmpl_data;

        return $this;
    }

    /**
     * @param int   $id_tmpl   Идентификатор шаблона
     * @param array $tmpl_data JSON объект, где ключи имена переменных в шаблоне
     *
     * @return $this
     */
    public function template(int $id_tmpl, array $tmpl_data) : self
    {
        $this->idTmpl($id_tmpl);
        $this->tmplData($tmpl_data);

        return $this;
    }

    /**
     * @param int $ttl время жизни сообщения в секундах (по умолчанию 7200)
     *
     * @return $this
     */
    public function ttl(int $ttl) : self
    {
        $this->ttl = $ttl;

        return $this;
    }

    /**
     * @param string $phone Список номеров телефонов получателей
     *
     * @return $this
     */
    public function to(string $phone) : self
    {
        $this->phones = json_encode([1 => ['phone' => $phone]]);

        return $this;
    }

    /**
     * @param string $action Совершаемое действие
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

        $this->id = implode(',', $ids);
        $this->action('get_status');

        return $this;
    }

    /**
     * Запрос списка Сервисов
     *
     * @return $this
     */
    public function services() : self
    {
        $this->action('get_service');

        return $this;
    }

    /**
     * Запрос списка Шаблонов
     *
     * @return $this
     */
    public function templates() : self
    {
        $this->action('get_tmpl');

        return $this;
    }

    /**
     * @param Closure $closure
     *
     * @return $this
     */
    public function package(Closure $closure) : self
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
     * @param string $text
     *
     * @return $this
     */
    public function sms(string $text = '') : self
    {
        $this->extra_param = array_merge($this->extra_param, [
            __FUNCTION__ => [
                'textSMS' => $text,
            ],
        ]);

        return $this;
    }

    /**
     * @param string $text
     * @param int    $validity
     *
     * @return VK
     */
    public function viber(string $text = '', int $validity = 0) : self
    {
        $this->extra_param = array_merge($this->extra_param, [
            __FUNCTION__ => [
                'textIM'         => $text,
                'validityPeriod' => $validity,
            ],
        ]);

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

        if ($this->extra_param) {
            $this->extraParamGenerated();
        }

        dump($this);

        return $this->streamTelecom->request()->data(get_object_vars($this))->uri(Constants::URI_VK_SEND)->vk()->get();
    }

    public function extraParamGenerated() : void
    {
        $template_message = $this->templateMessage();

        foreach ($this->extra_param as $k => $item) {
            dump($item);
            if (array_shift($item) === '') {
                $this->extra_param[$k][array_shift($item)] = $template_message;
            }
        }

    }

    private function templateMessage()
    {
        /*$templates = $this->templates()->streamTelecom->request()->data(get_object_vars($this))->uri(Constants::URI_VK_SEND)->vk()->get();

        $id_template = Helpers::recursive_array_search($this->id_tmpl, $templates);

        if ($id_template === false) {
            throw new \RuntimeException('Шаблон с заданым ID не найден.');
        }*/

//        $template_message = $templates[$id_template]['tmpl'];

        $template_message = '#username#, #balance#';

        $template_array = $this->tmpl_data;

        foreach ($template_array as $k => $v) {
            $template_array['#' . $k . '#'] = $v;
            unset($template_array[$k]);
        }

        return str_replace(array_keys($template_array), $template_array, $template_message);
    }
}
