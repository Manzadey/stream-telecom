<?php

namespace Manzadey\StreamTelecom\Viber;

class ViberStatusAnswer
{
    public function __construct(int $messageId, array $array)
    {
        $this->messageId = $messageId;
        $this->delivery_method = array_keys($array[$messageId])[0];

        foreach ($array[$messageId][$this->delivery_method] as $k => $value) {
            $this->$k = $value;
        }

        $this->error === 0 ? $this->error = false : $this->error = true;
    }

    public function getStateMessage() : string
    {
        $states = [
            'delivered'     => 'Доставлено',
            'undelivered'   => 'Не доставлено',
            'sent'          => 'Отправлено',
            'read'          => 'Прочитано',
            'expired'       => 'Просрочено',
        ];

        return array_key_exists($this->state, $states) ? $states[$this->state] : $this->state;
    }

    /**
     *  Цена за сообщение.
     *
     * @return float
     */
    public function getPrice() : float
    {
        return (float) $this->price;
    }

    public function getStateTime()
    {
        return new \DateTime($this->state_time);
    }

    public function getStateErrorMessage()
    {
        $errors = [
            'user-blocked'      => 'Абонент заблокирован',
            'not-viber-user'    => 'Абонент не является пользователем Viber',
            'filtered'          => 'Сообщение не соответствует ни одному зарегистрированному шаблону',
        ];

        return array_key_exists($this->error_info, $errors) ? $errors[$this->error_info] : $this->state;
    }
}
