<?php

namespace Manzadey\StreamTelecom\Request;

class Construct
{
    /**
     * @var Request
     */
    public $request;

    /**
     * Construct constructor.
     *
     * @param Request $request
     */
    final public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
