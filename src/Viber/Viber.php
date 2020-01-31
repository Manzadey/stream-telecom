<?php

namespace Manzadey\StreamTelecom\Viber;

use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\StreamTelecom;
use Manzadey\StreamTelecom\Support\Helpers;

class Viber
{
    public static $count_package = 1;
    /**
     * @var string
     */
    private $textIM;
    /**
     * @var int
     */
    private $phone;
    /**
     * @var int
     */
    private $validityPeriod;
    /**
     * @var string
     */
    private $imageURL;
    /**
     * @var string
     */
    private $buttonURL;
    /**
     * @var string
     */
    private $textSMS;
    /**
     * @var string
     */
    private $buttonText;
    /**
     * @var int
     */
    private $messageId;
    /**
     * @var StreamTelecom
     */
    private $streamTelecom;
    /**
     * @var array
     */
    private $phones;

    /**
     * Viber constructor.
     *
     * @param StreamTelecom $streamTelecom
     */
    public function __construct(StreamTelecom $streamTelecom)
    {
        $this->streamTelecom = $streamTelecom;
    }

    /**
     *  Текст отправляемого сообщения Viber (Сообщение не должно содержать более 1000 символов)
     *
     * @param string $text
     *
     * @return $this
     */
    public function text(string $text) : self
    {
        $this->textIM = $text;

        return $this;
    }

    /**
     *  Номер получателя сообщения Viber
     *
     * @param int $phone
     *
     * @return $this
     */
    public function to(int $phone) : self
    {
        $this->phone = $phone;

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
            'phone',
            'validityPeriod',
            'textIM',
            'imageURL',
            'buttonURL',
            'buttonText',
            'textSMS',
        ];

        $array = array_filter(get_object_vars($closure($this)));

        $attributes = array_filter($array, static function ($a) use ($fields) {
            return in_array($a, $fields, true);
        }, ARRAY_FILTER_USE_KEY);

        $attributes['type_viber'] = 'text';

        if (isset($attributes['imageURL'])) {
            $attributes['type_viber'] = 'image';
        }

        if (isset($attributes['buttonText'], $attributes['buttonURL'])) {
            $attributes['type_viber'] = 'button';
        }

        $this->phones[self::$count_package++] = $attributes;

        foreach (array_keys($attributes) as $attribute) {
            unset($this->$attribute);
        }

        return $this;
    }

    /**
     * Время ожидания доставки сообщения в секундах. По умолчанию 7200 секунд
     * Min=15, Max=86400
     *
     * @param int $validity
     *
     * @return $this
     */
    public function validity(int $validity) : self
    {
        $this->validityPeriod = $validity;

        return $this;
    }

    /**
     * URL изображения в формате: https://my.site.com/images/image.jpg. Длина URL изображения не более 1000 символов
     *
     * @param string $image
     *
     * @return $this
     */
    public function image(string $image) : self
    {
        $this->imageURL = $image;

        return $this;
    }

    /**
     * Наименование кнопки. (не более 30 символов)
     *
     * @param string $buttonText
     *
     * @return $this
     */
    public function buttonText(string $buttonText) : self
    {
        $this->buttonText = $buttonText;

        return $this;
    }

    /**
     * URL кнопки в формате: https://my.site.com/. Длина URL кнопки для перехода не более 1000 символов
     *
     * @param string $buttonUrl
     *
     * @return $this
     */
    public function buttonUrl(string $buttonUrl) : self
    {
        $this->buttonURL = $buttonUrl;

        return $this;
    }

    /**
     * Текст отправляемого сообщения SMS (каскад)
     *
     * @param string $text
     *
     * @return $this
     */
    public function sms(string $text = null) : self
    {
        if ($this->textIM === null) {
            throw new \RuntimeException('Укажите текст сообщения!');
        }

        $this->textSMS = $text ?? $this->textIM;

        return $this;
    }

    /**
     *  Id сообщения Viber(можно указывать несколько id через запятую)
     *
     * @param int $messageId
     *
     * @return $this
     */
    public function messageId(int $messageId) : self
    {
        $this->messageId = $messageId;

        return $this;
    }

    /**
     * @return array
     */
    public function data() : array
    {
        return array_filter(get_object_vars($this));
    }

    /**
     * @return mixed
     */
    public function get()
    {

        $data = $this->data();
        $uri  = Constants::URI_VIBER_SEND;

        if ($this->messageId) {
            $uri = Constants::URI_VIBER_STATUS;
        }

        if ($this->phones) {
            $uri = Constants::URI_VIBER_BULK;
        }

        return $this->streamTelecom->requestViber($uri, $data);
    }
}
