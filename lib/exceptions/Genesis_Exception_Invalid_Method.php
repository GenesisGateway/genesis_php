<?php

namespace Genesis;

class Genesis_Exception_Invalid_Method extends \Exception {
    public function __construct($message = '', $code = 0, Exception $previous = null) {
        $message = "You're trying to call a non-existent method. For proper usage, please refer to the official documentation.";
        parent::__construct($message, $code, $previous);
    }
}