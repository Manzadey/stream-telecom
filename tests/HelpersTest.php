<?php

namespace Manzadey\StreamTelecom\Test;

use Manzadey\StreamTelecom\Helpers;
use Manzadey\StreamTelecom\StreamTelecom;
use PHPUnit\Framework\TestCase;

class HelpersTest extends TestCase
{
    use Helpers;

    public function testGetBalanceHuman()
    {
        $balance_1 = 121;
        $result_1  = $balance_1 . ' рубль';
        $this->assertSame($this->getBalanceHuman($balance_1), $result_1);

        $balance_2 = 122;
        $result_2  = $balance_2 . ' рубля';
        $this->assertSame($this->getBalanceHuman($balance_2), $result_2);

        $balance_3 = 125;
        $result_3  = $balance_3 . ' рублей';
        $this->assertSame($this->getBalanceHuman($balance_3), $result_3);
    }

    public function testCreatingLink()
    {
        $st = new StreamTelecom('test', 'test', 'test');
        $result = $st->gate . '?' . 'test=1&test2=2';

        $create_link = $st->creatingLink(['test' => 1, 'test2' => 2]);

        $this->assertSame($result, $create_link);
    }
}