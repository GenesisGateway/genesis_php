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

namespace Genesis\API\Traits\Request\Mobile;

/**
* @method $this setPaymentSubtype($value) Sets payment type which is of authorize and recurring
* @method $this setTokenVersion($value) Sets version information about the payment token
* @method $this setTokenData($value) Sets encrypted payment data
* @method $this setTokenSignature($value) Sets signature of the payment and header data.
* @method $this setTokenEphemeralPublicKey($value) Sets Ephemeral public key bytes
* @method $this setTokenPublicKeyHash($value) Sets hash of encoded public key bytes of the merchant’s certificate
* @method $this setTokenTransactionId($value) Set transaction identifier, generated on the device
* @method $this setTokenDisplayName($value) Sets display name, which describes the card
* @method $this setTokenNetwork($value) Sets payment network describes the backing the card
* @method $this setTokenType($value) Sets card’s type
* @method $this setTokenTransactionIdentifier($value) Sets a unique identifier for this payment.
*/
trait ApplePayAttributes
{
    /**
     * Payment type
     *
     * @var string
     */
    protected $payment_subtype;

    /**
     * Version information about the payment token.
     *
     * @var string
     */
    protected $token_version;

    /**
     * Encrypted payment data.
     *
     * @var string
     */
    protected $token_data;

    /**
     * Signature of the payment and header data.
     *
     * @var string
     */
    protected $token_signature;

    /**
     * Ephemeral public key bytes.
     *
     * @var string
     */
    protected $token_ephemeral_public_key;

    /**
     * Hash of encoded public key bytes of the merchant’s certificate.
     *
     * @var string
     */
    protected $token_public_key_hash;

    /**
     * Transaction identifier, generated on the device
     *
     * @var string
     */
    protected $token_transaction_id;

   /**
    * describes the card
    * @var string
    */
    protected $token_display_name;

    /**
     * Describes the payment network backing the card
     *
     * @var string
     */
    protected $token_network;

    /**
     * Representing the card’s type
     *
     * @var string
     */
    protected $token_type;

    /**
     * A unique identifier for this payment.
     *
     * @var string
     */
    protected $token_transaction_identifier;

    public function getPaymentTokenStructure()
    {
        return json_encode([
                'paymentData' => [
                    'version'   => $this->token_version,
                    'data'      => $this->token_data,
                    'signature' => $this->token_signature,
                    'header'    => [
                        'ephemeralPublicKey' => $this->token_ephemeral_public_key,
                        'publicKeyHash'      => $this->token_public_key_hash,
                        'transactionId'      => $this->token_transaction_id
                    ]
                ],
                'paymentMethod' => [
                    'displayName' => $this->token_display_name,
                    'network'     => $this->token_network,
                    'type'        => $this->token_type
                ],
                'transactionIdentifier' => $this->token_transaction_identifier
            ], JSON_UNESCAPED_UNICODE);
    }
}
