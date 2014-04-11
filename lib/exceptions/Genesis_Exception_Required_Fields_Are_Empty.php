<?php

namespace Genesis;

class Genesis_Exception_Required_Fields_Are_Empty extends \Exception {
    public function __construct($message = '', $code = 0, Exception $previous = null) {
        $message = 'Please check your setup, there are empty fields marked required for this request';
        parent::__construct($message, $code, $previous);
    }
} 