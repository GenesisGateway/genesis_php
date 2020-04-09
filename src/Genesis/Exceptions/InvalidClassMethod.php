<?php

namespace Genesis\Exceptions;

class InvalidClassMethod extends Exception
{
    /**
     * @return string
     */
    protected function getCustomMessage()
    {
        return 'You\'re trying to call a non-existent method!';
    }
}
