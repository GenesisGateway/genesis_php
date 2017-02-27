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
namespace Genesis\API\Request\Base\Financial\Cards\Asynchronous;

/**
 * Class AbstractTransaction
 *
 * Abstract Base Class for Financial Card ASynchronous Payment Transactions
 *
 * @package Genesis\API\Request\Base\Financial\Cards\Asynchronous
 *
 * @method $this setReturnSuccessUrl($value) Set the URL where customer is sent to after successful payment
 * @method $this setReturnFailureUrl($value) Set the URL where customer is sent to after un-successful payment
 * @method $this setNotificationUrl($value) Set the URL endpoint for Genesis Notifications
 */
abstract class AbstractTransaction extends \Genesis\API\Request\Base\Financial\Cards\Synchronous\AbstractTransaction
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
                'return_success_url'  => $this->return_success_url,
                'return_failure_url'  => $this->return_failure_url,
                'notification_url'    => $this->notification_url
            )
        );
    }
}
