<?php

namespace Genesis;


class API_Notification extends Genesis_Base
{
    private $notificationBody;

    /**
     * Send a 'Notification Echo' request back to Genesis to
     * confirm that the notification is received and processed
     */
    public function acknowledgeNotification()
    {
        $unique_id = $this->notificationBody['unique_id'];

        $echo = new Genesis_API_Request();
        $echo->loadRequest('Notification_Echo');
        $echo->setUniqueId($unique_id);
        $echo->submitRequest();
    }

    /*
     * Parse the response from Genesis and extract the data we need
     * in order to verify the integrity of the notification and
     * process the data
     *
     *
     */
    public function parseResponse($data)
    {

    }

    /**
     * Verify the signature that in the Genesis response, to ensure that
     * this message is actually from Genesis and not an imposter.
     *
     * @return bool
     */
    public function verifySignature()
    {
        $unique_id          = $this->notificationBody['unique_id'];
        $customer_password  = Genesis_Configuration::getPassword();
        $message_signature  = $this->notificationBody['signature'];

        $hash_type = '';

        switch(strlen($message_signature))
        {
            default:
            case 40:
                $hash_type = 'sha1';
                break;
            case 128:
                $hash_type = 'sha512';
                break;
        }

        $calc_signature = hash($hash_type, $unique_id . $customer_password);

        if ($message_signature === $calc_signature) {
            return true;
        } else {
            return false;
        }
    }
} 