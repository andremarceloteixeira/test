<?php

namespace Language\Exception;
use Exception;


class BaseException extends Exception
{

    public function __construct ($message = "", $code = 403, Exception $previous = null)
    {
        parent::__construct($message, (int) $code, $previous);
    }

}