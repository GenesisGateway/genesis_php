<?php

namespace Genesis\API;

/**
 * Notification - process/validate incoming Async notifications
 *
 * @package Genesis
 * @subpackage API
 */
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
     * @var \ArrayObject()
     */
    private $notificationObj;

	/**
	 * Flag whether or not this notification is for a 3D transaction
	 *
	 * @var \bool
	 */
	private $is3DNotification;

	/**
	 * Flag whether or not this notification is for a WPC transaction
	 *
	 * @var \boolean
	 */
	private $isWPFNotification;

	/**
	 * Is this a 3D notification?
	 *
	 * @return bool
	 */
	public function is3DNotification()
	{
		return (bool)$this->is3DNotification;
	}

	/**
	 * Is this WPF Notification
	 *
	 * @return bool
	 */
	public function isWPFNotification()
	{
		return (bool)$this->isWPFNotification;
	}

    /**
     * Verify the signature on the parsed Notification
     *
     * @return bool
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function isAuthentic()
    {
	    if (!isset($this->unique_id) || !isset($this->notificationObj->signature)) {
		    throw new \Genesis\Exceptions\InvalidArgument('Missing field(s), required for validation!');
	    }

        $message_signature  = (string)$this->notificationObj->signature;
        $customer_password  = (string)\Genesis\GenesisConfig::getPassword();

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

        $calc_signature = hash($hash_type, $this->unique_id . $customer_password);

        if ($message_signature === $calc_signature) {
            return true;
        }

        return false;
    }

	/**
	 * Generate Builder response (Echo) required for acknowledging
	 * Genesis's Notification
	 *
	 * @return string
	 */
	public function getEchoResponse()
	{
		$structure = array (
			'notification_echo' => array (
				'unique_id' => $this->unique_id,
			)
		);

		$builder = new \Genesis\Builders\Builder();
		$builder->parseStructure($structure);

		return $builder->getDocument();
	}

	/**
	 * Render the Gateway response
	 *
	 * @param bool $terminate Exit after render (default: false)
	 *
	 * @return void
	 */
	public function renderResponse($terminate = false)
	{
		$structure = array (
			'notification_echo' => array (
				'unique_id' => $this->unique_id,
			)
		);

		$builder = new \Genesis\Builders\Builder();
		$builder->parseStructure($structure);

		header('Content-type: application/xml');
		echo $builder->getDocument();

		if ($terminate) exit(0);
	}

    /**
     * Return the already parsed, notification Object
     *
     * @return \ArrayObject
     */
    public function getParsedNotification()
    {
        return $this->notificationObj;
    }

    /**
     * Parse and Authenticate the incoming notification from Genesis
     *
     * @param array $notification - Incoming notification ($_POST)
     * @param bool  $authenticate - Set to true if you want to validate the notification
     * @throws \Genesis\Exceptions\InvalidArgument()
     */
    public function parseNotification($notification = array(), $authenticate = true)
    {
        $this->notificationObj = \Genesis\Utils\Common::createArrayObject($notification);

        if (isset($this->notificationObj->unique_id) && !empty($this->notificationObj->unique_id)) {
            $this->is3DNotification = true;

	        $this->unique_id = (string)$this->notificationObj->unique_id;
        }

        if (isset($this->notificationObj->wpf_unique_id) && !empty($this->notificationObj->wpf_unique_id)) {
	        $this->isWPFNotification = true;

            $this->unique_id = (string)$this->notificationObj->wpf_unique_id;
        }

	    if ($authenticate && !$this->isAuthentic()) {
		    throw new \Genesis\Exceptions\InvalidArgument('Invalid Genesis Notification!');
	    }
    }
}