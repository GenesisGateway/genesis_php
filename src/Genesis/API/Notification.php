<?php
/**
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
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis\API;

/**
 * Notification - process/validate incoming Async notifications
 *
 * @package    Genesis
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
     * Store the reconciled response
     *
     * @var \stdClass
     */
    private $reconciliationObj;

    /**
     * Initialize the object with notification data
     *
     * @param $data
     *
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function __construct($data = null)
    {
        if (!is_null($data)) {
            $this->parseNotification($data, true);
        }
    }

    /**
     * Parse and Authenticate the incoming notification from Genesis
     *
     * @param array $notification - Incoming notification ($_POST)
     * @param bool  $authenticate - Set to true if you want to validate the notification
     *
     * @throws \Genesis\Exceptions\InvalidArgument()
     */
    public function parseNotification($notification = [], $authenticate = true)
    {
        $notificationWalk = [];

        array_walk($notification, function ($val, $key) use (&$notificationWalk) {
            $key = trim(rawurldecode($key));
            $val = trim(rawurldecode($val));

            $notificationWalk[$key] = $val;
        });

        $notification = $notificationWalk;

        $this->notificationObj = \Genesis\Utils\Common::createArrayObject($notification);

        if ($this->isAPINotification()) {
            $this->unique_id = (string)$this->notificationObj->unique_id;
        }

        if ($this->isWPFNotification()) {
            $this->unique_id = (string)$this->notificationObj->wpf_unique_id;
        }

        if ($this->isKYCNotification()) {
            $this->unique_id = (string)$this->notificationObj->reference_id;
        }

        if ($authenticate && !$this->isAuthentic()) {
            throw new \Genesis\Exceptions\InvalidArgument('Invalid Genesis Notification!');
        }
    }

    /**
     * Reconcile with the Payment Gateway to get the latest
     * status on the transaction
     *
     * @throws \Genesis\Exceptions\InvalidResponse
     */
    public function initReconciliation()
    {
        $type = '';

        if ($this->isAPINotification()) {
            $type = 'NonFinancial\Reconcile\Transaction';
        } elseif ($this->isWPFNotification()) {
            $type = 'WPF\Reconcile';
        }

        $request = new \Genesis\Genesis($type);

        try {
            $request->request()->setUniqueId($this->unique_id);

            $request->execute();
        } catch (\Genesis\Exceptions\ErrorAPI $api) {
            // This is reconciliation, don't throw on ErrorAPI
        }

        return $this->reconciliationObj = $request->response()->getResponseObject();
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
            throw new \Genesis\Exceptions\InvalidArgument(
                'Missing field(s), required for validation!'
            );
        }

        $messageSig  = trim($this->notificationObj->signature);
        $customerPwd = trim(\Genesis\Config::getPassword());

        switch (strlen($messageSig)) {
            default:
            case 40:
                $hashType = 'sha1';
                break;
            case 128:
                $hashType = 'sha512';
                break;
        }

        if ($messageSig === hash($hashType, $this->unique_id . $customerPwd)) {
            return true;
        }

        return false;
    }

    /**
     * Is this API notification?
     *
     * @return bool
     */
    public function isAPINotification()
    {
        return !empty($this->notificationObj->unique_id);
    }

    /**
     * Is this WPF Notification?
     *
     * @return bool
     */
    public function isWPFNotification()
    {
        return !empty($this->notificationObj->wpf_unique_id);
    }

    /**
     * Is this KYC Notification?
     *
     * @return bool
     */
    public function isKYCNotification()
    {
        return !empty($this->notificationObj->reference_id);
    }

    /**
     * Return the already parsed, notification Object
     *
     * @return \ArrayObject
     */
    public function getNotificationObject()
    {
        return $this->notificationObj;
    }

    /**
     * Return the reconciled object
     *
     * @return \stdClass
     */
    public function getReconciliationObject()
    {
        return $this->reconciliationObj;
    }

    /**
     * Generate Builder response (Echo) required for acknowledging
     * Genesis's Notification
     *
     * @return string
     */
    public function generateResponse()
    {
        $structure = [
            'notification_echo' => [
                $this->getResponseIdField() => $this->unique_id
            ]
        ];

        $builder = new \Genesis\Builder('xml');
        $builder->parseStructure($structure);

        return $builder->getDocument();
    }

    /**
     * @return string
     */
    public function getResponseIdField()
    {
        switch (true) {
            case $this->isWPFNotification():
                return 'wpf_unique_id';
            case $this->isAPINotification():
                return 'unique_id';
            case $this->isKYCNotification():
                return 'reference_id';
            default:
                throw new \LogicException('Unknown notification type');
        }
    }

    /**
     * Render the Gateway response
     *
     * @return void
     */
    public function renderResponse()
    {
        if (!headers_sent()) {
            header('Content-type: application/xml', true);
        }

        // Clean the buffer
        ob_clean();

        echo $this->generateResponse();
    }
}
