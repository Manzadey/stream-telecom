<?php

namespace Manzadey\StreamTelecom;

use GuzzleHttp\Client as GClient;

final class Client
{
    public function rest($contentType = 'x-www-form-urlencoded')
    {
         return new GClient([
            'base_uri' => Constants::SERVER_REST,
            'headers'  => [
                'content-type' => 'application/' . $contentType,
            ],
        ]);

        return $client;
    }

    public function email($contentType = 'x-www-form-urlencoded')
    {
        return new GClient([
            'base_uri' => Constants::SERVER_EMAIL,
            'headers' => [
                'content-type' => 'application/' . $contentType,
            ],
        ]);
    }
}
