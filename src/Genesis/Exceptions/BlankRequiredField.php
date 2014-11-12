<?php

namespace Genesis\Exceptions;

class BlankRequiredField extends \Exception
{
    public function __construct($message = '', $code = false, \Exception $previous = null)
    {
        if (!$code)
            $message = sprintf("Please check your setup, field(s): %s is(are) empty!", $message);

        parent::__construct($message, $code, $previous);
    }
}
