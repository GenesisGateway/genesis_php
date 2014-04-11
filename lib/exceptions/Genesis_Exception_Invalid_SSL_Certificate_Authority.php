<?php

namespace Genesis;

class Genesis_Exception_Invalid_SSL_Certificate_Authority extends \Exception {
    public function __construct($message = '', $code = 0, Exception $previous = null) {
        $message = "Couldn't verify the Server Identity. Either the local CA is out-dated/missing or the server certificate is invalid.";
        parent::__construct($message, $code, $previous);
    }
};