<?php

namespace Genesis\Exceptions;

class MissingComponent extends \Exception
{
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        $message = sprintf("Missing dependency (%s). You can use Composer to install/update project dependencies!", $message);

        parent::__construct($message, $code, $previous);
    }
}