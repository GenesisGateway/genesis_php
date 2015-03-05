<?php
/*
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
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