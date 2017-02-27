<?php
namespace Genesis\API\Request\Base\Financial\Common\Risk\Async;

/**
 * Class AbstractBaseCustomerInfo
 *
 * Base Abstract Class for all Financial Asynchronous Risk Transaction Requests,
 * which require Billing & Shipping Addresses
 *
 * @package Genesis\API\Request\Base\Financial\Common
 *
 * @method $this setReturnSuccessUrl($value) Set the URL where customer is sent to after successful payment
 * @method $this setReturnFailureUrl($value) Set the URL where customer is sent to after un-successful payment
 * @method $this setNotificationUrl($value) Set the URL endpoint for Genesis Notifications
 */
abstract class AbstractBaseCustomerInfo extends \Genesis\API\Request\Base\Financial\Common\Risk\AbstractBaseCustomerInfo
{
    /**
     * URL where customer is sent to after successful payment
     *
     * @var string
     */
    protected $return_success_url;

    /**
     * URL where customer is sent to after un-successful payment
     *
     * @var string
     */
    protected $return_failure_url;

    /**
     * URL endpoint for Genesis Notifications
     *
     * @var string
     */
    protected $notification_url;

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getRequestTreeStructure()
    {
        $treeStructure = parent::getRequestTreeStructure();

        return array_merge(
            $treeStructure,
            array(
                'return_success_url' => $this->return_success_url,
                'return_failure_url' => $this->return_failure_url,
                'notification_url'   => $this->notification_url
            )
        );
    }
}
