<?php

namespace Manzadey\StreamTelecom\Support;

trait Handling
{
    /**
     * Error List
     *
     * @var array
     */
    private $errors = [
        'Неправильный логин или пароль'      => 'Введен неправильный логин или пароль.',
        'Ваш аккаунт заблокирован'           => 'Ваш аккаунт заблокирован.',
        'Данное направление закрыто для вас' => 'Введен некорректный номер телефона, либо у Вас закончились деньги по данному направлению.',
        'Нет отправителя'                    => 'Не введено имя отправителя.',
        'Нет текста сообщения'               => 'Не введен текст сообщения.',
        'Такого отправителя нет'             => 'Указано неверное имя отправителя.',
        'Укажите номер телефона'             => 'Не введен номер телефона.',
        'Flood SMS'                          => 'Множественная отправка смс на один номер с одинаковым текстом.',
    ];

    /**
     * @param string $response
     *
     * @return int|string
     */
    private function handleResponse(string $response)
    {
        if (array_key_exists($response, $this->errors)) {
            return $this->errors[$response];
        }

        return (int) $response;
    }
}