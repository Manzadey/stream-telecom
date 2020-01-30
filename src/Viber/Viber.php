<?php

namespace Manzadey\StreamTelecom\Viber;

use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\StreamTelecom;
use Manzadey\StreamTelecom\Support\Helpers;

class Viber
{
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
     * @param array $phone
     *
     * @return $this
     */
    public function to(array $phones) : self
    {
        $to = Helpers::phonesProcessing($phones);

        if ($to === '') {
            throw new \InvalidArgumentException('Отсутствуют валидные номера! Проверьте правильность вводимых номеров.');
        }

        $this->phone = $phones;

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
    public function sms(string $text = '') : self
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
     * @return mixed
     */
    public function get()
    {
        $data = array_filter(get_object_vars($this));
        $uri  = Constants::URI_VIBER_SEND;

        if ($this->messageId) {
            $uri = Constants::UTI_VIBER_STATUS;
        }

        return $this->streamTelecom->request($uri, $data);
    }
}
