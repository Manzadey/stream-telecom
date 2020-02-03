<?php

namespace Manzadey\StreamTelecom\Statistic;

use DateTime;
use Manzadey\StreamTelecom\Constants;
use Manzadey\StreamTelecom\Interfaces\ResponseInterface;
use Manzadey\StreamTelecom\StreamTelecom;
use Manzadey\StreamTelecom\Support\Helpers;

class Statistic implements ResponseInterface
{
    /**
     * @var StreamTelecom
     */
    protected $streamTelecom;
    /**
     * Дата и время начала периода, за который необходимо получить статистику
     *
     * @var DateTime
     */
    private $startDateTime;
    /**
     * Дата и время конца периода, за который необходимо получить статистику
     *
     * @var DateTime
     */
    private $endDateTime;
    /**
     * @var string
     */
    private $state;
    /**
     * @var int
     */
    private $type_load = '1';
    /**
     * @var int
     */
    private $sub_stat;
    /**
     * @var int
     */
    private $c_base;
    /**
     * @var int
     */
    private $phone;
    /**
     * @var bool
     */
    private $detail = false;

    /**
     * Statistic constructor.
     *
     * @param StreamTelecom $streamTelecom
     */
    public function __construct(StreamTelecom $streamTelecom)
    {
        $this->streamTelecom = $streamTelecom;
    }

    /**
     * @param string $start Дата и время начала периода, за который необходимо получить статистику
     *
     * @return Statistic
     * @throws \Exception
     */
    public function start(string $start) : self
    {
        $this->startDateTime = Helpers::dateFormatToUtc($start);

        return $this;
    }

    /**
     * @param string $end Дата и время конца периода, за который необходимо получить статистику,
     *
     * @return Statistic
     * @throws \Exception
     */
    public function end(string $end) : self
    {
        $this->endDateTime = Helpers::dateFormatToUtc($end);

        return $this;
    }

    /**
     * Формирование статистики по определенному статусу сообщений.  Допустимые значения deliver, not_deliver, expired,
     * sent  (доставлено, не доставлено, просрочено, в процессе) Необязательный
     *
     * @param string $state
     *
     * @return $this
     */
    public function state(string $state) : self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Формирование статистики по определенному номеру абонента. Необязательный
     *
     * @param int $phone
     *
     * @return $this
     */
    public function phone(int $phone) : self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Указывает на необходимость выгрузки данных с привязкой к базе адресатов. Допустимые
     * значения: 0, 1 (0 -по умолчанию) Необязательный
     *
     * @return $this
     */
    public function cBase() : self
    {
        $this->c_base = 1;

        return $this;
    }

    /**
     * Указывает на необходимость выгрузки данных с подлогинов.Допустимые значения: 0, 1 (0 - по умолчанию) Не
     * обязательный.
     *
     * @return $this
     */
    public function subStat() : self
    {
        $this->sub_stat = 1;

        return $this;
    }

    /**
     * Выбор формата отчета. Допустимые значения: 0, 1 (0 -csv по умолчанию, 1 -xls) Необязательный.
     *
     * @param string $type_load
     */
    public function typeLoad(string $type_load)
    {
        $this->type_load = $type_load;
    }

    /**
     * @return $this
     */
    public function detail() : self
    {
        $this->detail = true;

        return $this;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        if ($this->startDateTime === null) {
            throw new \InvalidArgumentException('Укажите дату и время НАЧАЛА периода, за который необходимо получить статистику!');
        }

        if ($this->endDateTime === null) {
            throw new \InvalidArgumentException('Укажите дату и время КОНЦА периода, за который необходимо получить статистику!');
        }

        $this->detail ? $uri = Constants::URI_STATISTIC_DETAIL : $uri = Constants::URI_STATISTIC;

        return $this->streamTelecom->request()->uri($uri)->data(get_object_vars($this))->method('GET')->main()->get();
    }

    /**
     * @param int $report_id
     *
     * @return mixed
     */
    public function download(int $report_id)
    {
        return $this->streamTelecom->request()->uri(Constants::URI_STATISTIC_DETAIL)->data(compact('report_id'))->main()->get();
    }

}
