<?php

namespace Manzadey\StreamTelecom;

use GuzzleHttp\Client as GClient;

class Client
{
    /**
     * @param string $contentType
     *
     * @return GClient
     */
    public function rest($contentType = 'x-www-form-urlencoded') : GClient
    {
         return new GClient([
            'base_uri' => Constants::SERVER_REST,
            'headers'  => [
                'content-type' => 'application/' . $contentType,
            ],
        ]);
    }

    /**
     * @param string $contentType
     *
     * @return GClient
     */
    public function email($contentType = 'x-www-form-urlencoded') : GClient
    {
        return new GClient([
            'base_uri' => Constants::SERVER_EMAIL,
            'headers' => [
                'content-type' => 'application/' . $contentType,
            ],
        ]);
    }
}
