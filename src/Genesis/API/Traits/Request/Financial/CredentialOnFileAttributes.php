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

namespace Genesis\API\Traits\Request\Financial;

use Genesis\API\Constants\Transaction\Parameters\CredentialOnFile;

/**
 * Credential On File (COF)
 * Growth in digital commerce, together with the emergence of new business models,
 * has increased the number of transactions where a merchant or its agent,
 * a payment facilitator (PF),
 * or a staged digital wallet operator (SDWO) uses cardholder payment credentials (i.e., account details) that
 * they previously stored for future purchases.
 *
 * Trait CredentialOnFileAttributes
 * @package Genesis\API\Traits\Request\Financial
 *
 * @method string getCredentialOnFile() COF indicator
 */
trait CredentialOnFileAttributes
{
    /**
     * The COF indicator.
     * The Credential On File indicator can be used for the following transaction types:
     *      Account Verification,
     *      Authorize, Authorize3D,
     *      Sale, Sale3D,
     *      InitRecurringSale, InitRecurringSale3D,
     *      Payout
     *
     * @var string $credential_on_file
     */
    protected $credential_on_file;

    /**
     * The COF indicator
     *
     * @param string $value
     * @return $this
     */
    public function setCredentialOnFile($value)
    {
        if (empty($value)) {
            $this->credential_on_file = null;

            return $this;
        }

        return $this->allowedOptionsSetter(
            'credential_on_file',
            CredentialOnFile::getAll(),
            $value,
            'Invalid Credential On File indicator.'
        );
    }

    /**
     * Return the COF Parameters Structure
     *
     * @return array
     */
    protected function getCredentialOnFileAttributesStructure()
    {
        return [
            'credential_on_file' => $this->credential_on_file
        ];
    }
}
