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

namespace Genesis\API\Traits\Request;

/**
 * Trait RiskAttributes
 * @package Genesis\API\Traits\Request
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
 * @method $this setRiskPanTail($value) Set the last 4 digits of the card number
 * @method $this setRiskBin($value) Set the first 6 digits of the card number
 * @method $this setRiskFirstName($value) Set the Customer's First Name
 * @method $this setRiskLastName($value) Set the Customer's Last Name
 * @method $this setRiskCountry($value) Set the Customer's Country
 * @method $this setRiskPan($value) Set the Pan hash of the Customer's card number
 * @method $this setRiskForwardedIp($value) Set the Customer's Forwarded IP Address. MaxMind specific risk param.
 * @method $this setRiskUsername($value) Set the Customer's username. MaxMind specific risk param.
 * @method $this setRiskPassword($value) Set the Customer's password. MaxMind specific risk param.
 * @method $this setRiskBinName($value) Set the Customer's Bin Name. MaxMind specific risk param.
 * @method $this setRiskBinPhone($value) Set the Customer's Bin Phone. MaxMind specific risk param.
 */
trait RiskAttributes
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
     * The last 4 digits of the Customer's card number
     *
     * @var string
     */
    protected $risk_pan_tail;

    /**
     * The first 6 digits of the Customer's card number
     *
     * @var string
     */
    protected $risk_bin;

    /**
     * Customer's First Name
     *
     * @var string
     */
    protected $risk_first_name;

    /**
     * Customer's Last Name
     *
     * @var string
     */
    protected $risk_last_name;

    /**
     * Customer's Country
     *
     * @var string
     */
    protected $risk_country;

    /**
     * PAN Hash of the Customer's card number
     *
     * @var string
     */
    protected $risk_pan;

    /**
     * Customer's Forwarded IP Address
     *
     * @note MaxMind specific risk param.
     *
     * @var string
     */
    protected $risk_forwarded_ip;

    /**
     * Customer's Username
     *
     * @note MaxMind specific risk param.
     *
     * @var string
     */
    protected $risk_username;

    /**
     * Customer's Password
     *
     * @note MaxMind specific risk param.
     *
     * @var string
     */
    protected $risk_password;

    /**
     * Customer's Bin Name
     *
     * @note MaxMind specific risk param.
     *
     * @var string
     */
    protected $risk_bin_name;

    /**
     * Customer's Bin Phone
     *
     * @note MaxMind specific risk param.
     *
     * @var string
     */
    protected $risk_bin_phone;

    /**
     * Builds an array list with all Risk Params
     *
     * @return array
     */
    protected function getRiskParamsStructure()
    {
        return [
            'ssn'           => $this->risk_ssn,
            'mac_address'   => $this->risk_mac_address,
            'session_id'    => $this->risk_session_id,
            'user_id'       => $this->risk_user_id,
            'user_level'    => $this->risk_user_level,
            'email'         => $this->risk_email,
            'phone'         => $this->risk_phone,
            'remote_ip'     => $this->risk_remote_ip,
            'serial_number' => $this->risk_serial_number,
            'pan_tail'      => $this->risk_pan_tail,
            'bin'           => $this->risk_bin,
            'first_name'    => $this->risk_first_name,
            'last_name'     => $this->risk_last_name,
            'country'       => $this->risk_country,
            'pan'           => $this->risk_pan,
            'forwarded_ip'  => $this->risk_forwarded_ip,
            'username'      => $this->risk_username,
            'password'      => $this->risk_password,
            'bin_name'      => $this->risk_bin_name,
            'bin_phone'     => $this->risk_bin_phone
        ];
    }
}
