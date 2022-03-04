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

namespace Genesis\API\Traits\Request\Mobile;

use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * @codingStandardsIgnoreStart
 * @method $this setPaymentSubtype($value) Sets payment type, one of authorize, recurring, sale
 * @method $this setTokenSignature($value) Verifies that the message came from Google
 * @method $this setTokenSignedKey($value) A base64-encoded message that contains payment description of the key
 * @method $this setTokenProtocolVersion($value) Identifies the encryption or signing scheme under which the message is created
 * @method $this setTokenSignedMessage($value) A JSON object serialized as an HTML-safe string that contains the encryptedMessage, ephemeralPublicKey, and tag
 * @codingStandardsIgnoreStart
 */
trait GooglePayAttributes
{
    /**
     * Payment type: authorize, recurring, sale
     *
     * @var string
     */
    protected $payment_subtype;

    /**
     * Verifies that the message came from Google. It's base64-encoded, and created
     * with ECDSA by the intermediate signing key.
     *
     * @var string
     */
    protected $token_signature;

    /**
     * A base64-encoded message that contains payment description of the key.
     *
     * @var string
     */
    protected $token_signed_key;

    /**
     * Verifies that the intermediate signing key came from Google.
     * It's base64-encoded, and created with ECDSA.
     *
     * @var array
     */
    protected $token_signatures = [];

    /**
     * Identifies the encryption or signing scheme under which the message is created.
     * It allows the protocol to evolve over time, if needed.
     *
     * @var string
     */
    protected $token_protocol_version;

    /**
     * A JSON object serialized as an HTML-safe string that contains the
     * encryptedMessage, ephemeralPublicKey, and tag. It's serialized to
     * simplify the signature verification process.
     *
     * @var string
     */
    protected $token_signed_message;

    /**
     * Set token signatures
     * @param array|null $signatures
     * @return $this
     * @throws InvalidArgument
     */
    public function setTokenSignatures($signatures)
    {
        if (empty($signatures)) {
            $this->token_signatures = null;

            return $this;
        }

        if (!CommonUtils::isValidArray($signatures)) {
            throw new InvalidArgument(
                'Invalid value given for Token Signatures. Accept array'
            );
        }

        $this->token_signatures = $signatures;

        return $this;
    }

    /**
     * Used to assemble Google Pay token
     *
     * @return false|string
     */
    public function getPaymentTokenStructure()
    {
        return json_encode([
            'signature'              => $this->token_signature,
            'protocolVersion'        => $this->token_protocol_version,
            'signedMessage'          => $this->token_signed_message,
            'intermediateSigningKey' => [
                'signedKey'  => $this->token_signed_key,
                'signatures' => $this->token_signatures,
            ],
        ], JSON_UNESCAPED_UNICODE);
    }
}
