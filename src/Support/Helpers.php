<?php

namespace Manzadey\StreamTelecom\Support;

class Helpers
{
    /**
     * @param string $dateTime
     *
     * @return string
     * @throws \Exception
     */
    public static function dateFormatToUtc(string $dateTime) : string
    {
        $res = new \DateTime($dateTime);
        $res = $res->format('c');
        $res = substr($res, 0, 19);

        return $res;
    }

    /**
     * @param array $phones
     *
     * @return string
     */
    public static function phonesProcessing(array $phones) : string
    {
        $result = [];

        foreach ($phones as $phone) {
            $result[] = preg_replace('/[\D]/', '', $phone);
        }

        return implode(',', $result);
    }
}