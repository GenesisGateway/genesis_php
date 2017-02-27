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
namespace Genesis\API\Request\Base\Financial\Common\Risk;

/**
 * Class AbstractBase
 *
 * Base Abstract Class for Financial Risk Transaction Request
 *
 * @package Genesis\API\Request\Base\Financial\Common
 *
 * @method $this setRiskSsn($value) Set the Social Security number or equivalent value for non US customers.
 * @method $this setRiskMacAddress($value) Set the Customer's MAC address
 * @method $this setRiskSessionId($value) Set the Customer's Session Id
 * @method $this setRiskUserId($value) Set the Customer's User Id
 * @method $this setRiskUserLevel($value) Set the Customer's User Level
 * @method $this setRiskEmail($value) Set the Customer's Email address
 * @method $this setRiskPhone($value) Set the Customer's Phone number
 * @method $this setRiskRemoteIp($value) Set the Customer's IP address
 * @method $this setRiskSerialNumber($value) Set the Customer's Serial Number
 */
abstract class AbstractBase extends \Genesis\API\Request\Base\Financial\Common\AbstractPayment
{
    /**
     * Social Security number or equivalent value for non US customers.
     *
     * @var string
     */
    protected $risk_ssn;

    /**
     * Customer's MAC address
     *
     * @var string
     */
    protected $risk_mac_address;

    /**
     * Customer's Session Id
     *
     * @var string
     */
    protected $risk_session_id;

    /**
     * Customer's User Id
     *
     * @var string
     */
    protected $risk_user_id;

    /**
     * Customer's User Level
     *
     * @var string
     */
    protected $risk_user_level;

    /**
     * Customer's Email address
     *
     * @note Set here if different from
     *       shipping / billing
     *
     * @var string
     */
    protected $risk_email;

    /**
     * Customer's Phone number
     *
     * @note Set here if different from
     *       shipping / billing
     *
     * @var string
     */
    protected $risk_phone;

    /**
     * Customer's IP address
     *
     * @note Set here if different from remote_ip
     *
     * @var string
     */
    protected $risk_remote_ip;

    /**
     * Customer's Serial Number
     *
     * @var string
     */
    protected $risk_serial_number;

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
                'risk_params' => array(
                    'ssn'           => $this->risk_ssn,
                    'mac_address'   => $this->risk_mac_address,
                    'session_id'    => $this->risk_session_id,
                    'user_id'       => $this->risk_user_id,
                    'user_level'    => $this->risk_user_level,
                    'email'         => $this->risk_email,
                    'phone'         => $this->risk_phone,
                    'remote_ip'     => $this->risk_remote_ip,
                    'serial_number' => $this->risk_serial_number
                ),
            )
        );
    }
}
