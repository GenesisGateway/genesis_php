<?php

namespace Genesis\API;

use Genesis\Exceptions;
use Genesis\Configuration;
use Genesis\Builders as Builders;

class Notification
{
    /**
     * Store the Unique Id of the transaction
     *
     * @var string
     */
    private $unique_id;

    /**
     * Store the incoming notification as an object
     *
     * @var \stdClass()
     */
    private $notificationObj;

    /**
     * Generate XML response (Echo) required for acknowledging
     * Genesis's Notification
     *
     * @return string
     */
    public function generateResponse()
    {
        $echo_structure = array (
            'notification_echo' => array (
                'unique_id' => $this->unique_id,
            )
        );

        $xmlDocument = new Builders\XML();
        $xmlDocument->parseStructure($echo_structure);
        return $xmlDocument->getDocument();
    }

    /**
     * Parse the incoming notification from Genesis
     *
     * @param $response
     * @throws Exceptions\InvalidArgument()
     */
    public function parseNotification($response)
    {
        $response_parser = new Response();
        $response_parser->parseNotification($response);
        $this->notificationObj = $response_parser->getResponseObject();

        if (isset($this->notificationObj->unique_id) && !empty($this->notificationObj->unique_id)) {
            $this->unique_id = $this->notificationObj->unique_id;
        }

        if (isset($this->notificationObj->wpf_unique_id) && !empty($this->notificationObj->wpf_unique_id)) {
            $this->unique_id = $this->notificationObj->wpf_unique_id;
        }

        if (empty($this->notificationObj->unique_id) || empty($this->notificationObj->signature) || empty($this->notificationObj->status))
        {
            throw new Exceptions\InvalidArgument();
        }
    }

    /**
     * Verify the signature that inside the Notification, to ensure that
     * this message is actually from Genesis and not an imposter.
     *
     * @return bool
     */
    public function verifyAuthenticity()
    {
        $unique_id          = $this->unique_id;
        $message_signature  = $this->notificationObj->signature;
        $customer_password  = Configuration::getPassword();

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
            if (isset($this->notificationObj->status) && $this->notificationObj->status == 'approved') {
                return true;
            }

            if (isset($this->notificationObj->wpf_status) && $this->notificationObj->wpf_status == 'approved') {
                return true;
            }
        }

        return false;
    }
}