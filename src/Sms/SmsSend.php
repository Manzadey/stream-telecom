<?php

namespace Manzadey\StreamTelecom\Sms;

use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\Interfaces\ResponseInterface;
use Manzadey\StreamTelecom\StreamTelecom;
use Manzadey\StreamTelecom\Support\Helpers;

class SmsSend implements ResponseInterface
{
    public static $count_package = 0;
    /**
     * @var StreamTelecom
     */
    private $streamTelecom;
    /**
     * @var string
     */
    private $data;
    /**
     * @var false|string
     */
    private $sendDate;
    /**
     * @var int
     */
    private $validity;
    /**
     * @var string
     */
    public $query_uri = Constants::QUERY_SIMPLE['uri'];
    /**
     * @var ResponseInterface
     */
    public $response;
    /**
     * @var mixed
     */
    private $phone_data;

    /**
     * SmsSend constructor.
     *
     * @param StreamTelecom $streamTelecom
     */
    public function __construct(StreamTelecom $streamTelecom)
    {
        $this->streamTelecom = $streamTelecom;
    }

    /**
     * Текст сообщения.
     *
     * @param string $text
     *
     * @return $this
     */
    public function text(string $text) : self
    {
        $this->data = urlencode($text);

        return $this;
    }

    /**
     * Номера получателя сообщения, в международном формате: код страны + код сети + номер телефона.
     *
     * @param array $phones
     *
     * @return $this
     */
    public function to(array $phones) : self
    {
        $to = Helpers::phonesProcessing($phones);

        $this->to = $to;

        if ($to === '') {
            throw new \InvalidArgumentException('Отсутствуют валидные номера! Проверьте правильность вводимых номеров.');
        }

        $query = Constants::QUERY_SIMPLE['query'];

        if (strpos($to, ',') !== false) {
            $this->query_uri = Constants::QUERY_MULTIPLE['uri'];
            $query           = Constants::QUERY_MULTIPLE['query'];
            $this->$query    = $to;
        } else {
            $this->$query = $to;
        }

        return $this;
    }

    /**
     * Дата и время отправки. Если не требуется отложенная отправка, то передавать данный
     * параметр не нужно. Время указывается по UTC. Необязательный.
     *
     * @param string $date
     *
     * @return $this|string
     * @throws \Exception
     */
    public function date(string $date)
    {
        $this->sendDate = Helpers::dateFormatToUtc($date);
        return $this;
    }

    /**
     * Время жизни сообщения, устанавливается в минутах.
     *
     * @param int $minutes
     *
     * @return $this
     */
    public function validity(int $minutes) : self
    {
        $this->validity = $minutes;

        return $this;
    }

    /**
     * Пакетная отправка СМС-сообщения
     *
     * @param \Closure $closure
     *
     * @return $this
     */
    public function package(\Closure $closure) : self
    {
        $array = [
            'phone' => $closure($this)->to,
            'text'  => $closure($this)->data,
        ];

        $this->phone_data['sms'][self::$count_package++] = $array;

        unset($this->to, $this->destinationAddresses, $this->destinationAddress, $this->data);

        return $this;
    }

    /**
     * @return array
     */
    public function get() : array
    {
        if ($this->phone_data) {
            $this->query_uri  = Constants::QUERY_MULTIPLE_PACKET;
            $this->phone_data = json_encode($this->phone_data, true);
        }

        $this->response = $this->streamTelecom->request($this->query_uri, get_object_vars($this));

        $sms_response = new SmsResponse($this);

        return $sms_response->processingResponse();

    }
}