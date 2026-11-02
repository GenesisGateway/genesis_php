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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\NonFinancial\Kyc;

use Genesis\Utils\Common;

/**
 * Trait KycVerificationInstructions
 *
 * Verification instructions control which kinds of document captures are accepted
 * (paper based, photocopy, laminated, screenshot, cropped, scanned).
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Kyc
 *
 * @method bool getVerificationInstructionsAllowPaperBased()
 * @method bool getVerificationInstructionsAllowPhotocopy()
 * @method bool getVerificationInstructionsAllowLaminated()
 * @method bool getVerificationInstructionsAllowScreenshot()
 * @method bool getVerificationInstructionsAllowCropped()
 * @method bool getVerificationInstructionsAllowScanned()
 */
trait KycVerificationInstructions
{
    /**
     * Allow paper based document captures
     *
     * @var bool
     */
    protected $verification_instructions_allow_paper_based;

    /**
     * Allow photocopy document captures
     *
     * @var bool
     */
    protected $verification_instructions_allow_photocopy;

    /**
     * Allow laminated document captures
     *
     * @var bool
     */
    protected $verification_instructions_allow_laminated;

    /**
     * Allow screenshot document captures
     *
     * @var bool
     */
    protected $verification_instructions_allow_screenshot;

    /**
     * Allow cropped document captures
     *
     * @var bool
     */
    protected $verification_instructions_allow_cropped;

    /**
     * Allow scanned document captures
     *
     * @var bool
     */
    protected $verification_instructions_allow_scanned;

    /**
     * Set the correct value for Verification Instructions Allow Paper Based - boolean
     *
     * @param $value
     * @return $this
     */
    public function setVerificationInstructionsAllowPaperBased($value)
    {
        $this->verification_instructions_allow_paper_based = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Verification Instructions Allow Photocopy - boolean
     *
     * @param $value
     * @return $this
     */
    public function setVerificationInstructionsAllowPhotocopy($value)
    {
        $this->verification_instructions_allow_photocopy = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Verification Instructions Allow Laminated - boolean
     *
     * @param $value
     * @return $this
     */
    public function setVerificationInstructionsAllowLaminated($value)
    {
        $this->verification_instructions_allow_laminated = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Verification Instructions Allow Screenshot - boolean
     *
     * @param $value
     * @return $this
     */
    public function setVerificationInstructionsAllowScreenshot($value)
    {
        $this->verification_instructions_allow_screenshot = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Verification Instructions Allow Cropped - boolean
     *
     * @param $value
     * @return $this
     */
    public function setVerificationInstructionsAllowCropped($value)
    {
        $this->verification_instructions_allow_cropped = Common::toBoolean($value);

        return $this;
    }

    /**
     * Set the correct value for Verification Instructions Allow Scanned - boolean
     *
     * @param $value
     * @return $this
     */
    public function setVerificationInstructionsAllowScanned($value)
    {
        $this->verification_instructions_allow_scanned = Common::toBoolean($value);

        return $this;
    }

    /**
     * Get the correct structure for Verification Instructions
     *
     * @return array
     */
    protected function getVerificationInstructionsStructure()
    {
        return [
            'allow_paper_based' => $this->verification_instructions_allow_paper_based,
            'allow_photocopy'   => $this->verification_instructions_allow_photocopy,
            'allow_laminated'   => $this->verification_instructions_allow_laminated,
            'allow_screenshot'  => $this->verification_instructions_allow_screenshot,
            'allow_cropped'     => $this->verification_instructions_allow_cropped,
            'allow_scanned'     => $this->verification_instructions_allow_scanned
        ];
    }
}
