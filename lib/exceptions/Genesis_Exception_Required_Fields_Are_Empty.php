<?php

namespace Genesis;

class Genesis_Exception_Required_Fields_Are_Empty extends \Exception {
    public function __construct($message = '', $code = 0, Exception $previous = null) {
        $message = 'Please check your setup, field: ' . $message . ' is empty!';
        parent::__construct($message, $code, $previous);
    }
} 