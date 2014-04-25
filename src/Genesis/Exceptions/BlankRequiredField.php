<?php

namespace Genesis\Exceptions;

class BlankRequiredField extends \Exception
{
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        $message = sprintf("Please check your setup, field: %s is empty!", $message);

        parent::__construct($message, $code, $previous);
    }
}
