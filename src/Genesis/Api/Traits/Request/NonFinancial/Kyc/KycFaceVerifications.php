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
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\NonFinancial\Kyc;

use Genesis\Utils\Common;

/**
 * Trait KycFaceVerifications
 *
 * Represents the options to be supplied to the service in order to provide face verification functionality
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Kyc
 *
 * @method bool getFaceAllowOffline()
 * @method bool getFaceAllowOnline()
 * @method bool getFaceCheckDuplicateRequest()
 */
trait KycFaceVerifications
{
    /**
     * Whether uploading of previously taken picture is allowed for verification of document/face
     *
     * @var bool
     */
    protected $face_allow_offline;

    /**
     * Whether the realtime usage of device camera is allowed for verification of document/face
     *
     * @var bool
     */
    protected $face_allow_online;

    /**
     * Whether to enable the duplicate account detection service
     *
     * @var bool
     */
    protected $face_check_duplicate_request;

    /**
     * Set the correct Verifications Face Allow Offline - boolean
     *
     * @param $value
     * @return $this
     */
    public function setFaceAllowOffline($value)
    {
        $this->face_allow_offline = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct Verifications Face Allow Online - boolean
     *
     * @param $faceAllowOnline
     * @return $this
     */
    public function setFaceAllowOnline($faceAllowOnline)
    {
        $this->face_allow_online = Common::toBoolean($faceAllowOnline);

        return $this;
    }


    /**
     * Set the correct Verifications Face Check Duplicate request - boolean
     *
     * @param $value
     * @return $this
     */
    public function setFaceCheckDuplicateRequest($value)
    {
        $this->face_check_duplicate_request = Common::toBoolean($value);

        return $this;
    }

    /**
     * Return the correct structure for Verifications Face
     *
     * @return array
     */
    protected function getVerificationFaceStructure()
    {
        return [
            'allow_offline'           => $this->face_allow_offline,
            'allow_online'            => $this->face_allow_online,
            'check_duplicate_request' => $this->face_check_duplicate_request
        ];
    }
}
