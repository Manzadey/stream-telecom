<?php

namespace Manzadey\StreamTelecom\Interfaces;

interface SessionInterface
{
    public function request(string $uri, array $data, string $method);
}