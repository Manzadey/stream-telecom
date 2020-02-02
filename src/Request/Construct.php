<?php

namespace Manzadey\StreamTelecom\Request;

class Construct
{
    final public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
