<?php

namespace Genesis\Exceptions;

class NetworkError extends \Exception
{
    public function __construct($message = '', $code = 0, $previous = null)
    {
	    if (empty($message)) {
		    $message = 'Unknown error during network request!';
	    }

        parent::__construct($message, $code, $previous);
    }
}
