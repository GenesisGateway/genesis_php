<?php

namespace Genesis\Exceptions;

class InvalidMethod extends \Exception
{
    public function __construct($message = '', $code = 0, $previous = null)
    {
        if (empty($message)) {
	        $message = "You're trying to call a non-existent method. For proper usage, please refer to the documentation.";
        }

        parent::__construct($message, $code, $previous);
    }
}
