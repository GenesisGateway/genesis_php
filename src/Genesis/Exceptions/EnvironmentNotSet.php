<?php

namespace Genesis\Exceptions;

class EnvironmentNotSet extends \Exception
{
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        $message = "No working enviorment has been set, please consult the API and set the enviorment.";

        parent::__construct($message, $code, $previous);
    }
}
