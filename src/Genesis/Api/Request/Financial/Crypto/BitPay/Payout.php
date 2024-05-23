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

namespace Genesis\Api\Request\Financial\Crypto\BitPay;

use Genesis\Api\Traits\Request\AddressInfoAttributes;
use Genesis\Api\Traits\Request\Financial\AsyncAttributes;
use Genesis\Api\Traits\Request\Financial\PaymentAttributes;
use Genesis\Exceptions\ErrorParameter;

/**
 * BitPay Payout is a crypto currency payout method where merchants are requesting
 * payouts in FIAT currency and the funds are transfered in Bitcoin equivalent to a crypto wallet address.
 *
 * @package Genesis\Api\Request\Financial\Crypto\BitPay
 */
class Payout extends \Genesis\Api\Request\Base\Financial
{
    use AddressInfoAttributes;
    use AsyncAttributes;
    use PaymentAttributes;

    const WALLET_PROVIDER_BITGO    = 'bitgo';
    const WALLET_PROVIDER_UPHOLD   = 'uphold';
    const WALLET_PROVIDER_CIRCLE   = 'circle';
    const WALLET_PROVIDER_COINBASE = 'coinbase';
    const WALLET_PROVIDER_GDAX     = 'gdax';
    const WALLET_PROVIDER_GEMINI   = 'gemini';
    const WALLET_PROVIDER_ITBIT    = 'itbit';
    const WALLET_PROVIDER_KRAKEN   = 'kraken';

    const CRYPTO_ADDRESS_VALIDATION_REGEX = '/\A[132nm][a-zA-Z1-9]{26,34}\z/';

    /**
     * Valid crypto address where the funds will be received
     *
     * @var string
     */
    protected $crypto_address;

    /**
     * If crypto wallet provider is not in the table below, you must send ’other’
     *
     * @var string
     */
    protected $crypto_wallet_provider;

    /**
     * Valid crypto address where the funds will be received
     *
     * @param $address
     *
     * @return $this
     * @throws ErrorParameter
     */
    public function setCryptoAddress($address)
    {
        if (!$this->checkAddress($address) || !preg_match(static::CRYPTO_ADDRESS_VALIDATION_REGEX, $address)) {
            throw new ErrorParameter('Invalid crypto address provided');
        }

        $this->crypto_address = $address;

        return $this;
    }

    /**
     * Taken from https://github.com/tenfef/btc_address_validator
     *
     * @param $address
     *
     * @return bool
     */
    public function checkAddress($address)
    {
        $addr = $this->decodeBase58($address);
        if (strlen($addr) != 50) {
            return false;
        }
        $check = substr($addr, 0, strlen($addr) - 8);
        $check = pack('H*', $check);
        $check = strtoupper(hash('sha256', hash('sha256', $check, true)));
        $check = substr($check, 0, 8);

        return $check == substr($addr, strlen($addr) - 8);
    }

    /**
     * @param $dec
     *
     * @return string
     */
    private function encodeHex($dec)
    {
        $hexchars = '0123456789ABCDEF';
        $return   = '';
        while (bccomp($dec, 0) == 1) {
            $rem    = (int)bcmod($dec, '16');
            $dec    = (string)bcdiv($dec, '16', 0);
            $return = $return . $hexchars[$rem];
        }

        return strrev($return);
    }

    /**
     * Convert a Base58-encoded integer into the equivalent hex string representation
     *
     * @param string $base58
     *
     * @return string
     * @access private
     */
    private function decodeBase58($base58)
    {
        $origbase58  = $base58;
        $base58chars = '123456789ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz';
        $return      = '0';
        for ($i = 0; $i < strlen($base58); $i++) {
            $current = (string)strpos($base58chars, $base58[$i]);
            $return  = (string)bcmul($return, "58", 0);
            $return  = (string)bcadd($return, $current, 0);
        }
        $return = $this->encodeHex($return);
        //leading zeros
        for ($i = 0; $i < strlen($origbase58) && $origbase58[$i] == '1'; $i++) {
            $return = '00' . $return;
        }
        if (strlen($return) % 2 != 0) {
            $return = '0' . $return;
        }

        return $return;
    }

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\Api\Constants\Transaction\Types::BITPAY_PAYOUT;
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'crypto_address',
            'crypto_wallet_provider'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldValues = [
            'crypto_wallet_provider' => [
                self::WALLET_PROVIDER_BITGO,
                self::WALLET_PROVIDER_UPHOLD,
                self::WALLET_PROVIDER_CIRCLE,
                self::WALLET_PROVIDER_COINBASE,
                self::WALLET_PROVIDER_GDAX,
                self::WALLET_PROVIDER_GEMINI,
                self::WALLET_PROVIDER_ITBIT,
                self::WALLET_PROVIDER_KRAKEN
            ]
        ];

        $this->requiredFieldValues = \Genesis\Utils\Common::createArrayObject($requiredFieldValues);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'usage'                  => $this->usage,
            'remote_ip'              => $this->remote_ip,
            'return_success_url'     => $this->return_success_url,
            'return_failure_url'     => $this->return_failure_url,
            'amount'                 => $this->transformAmount($this->amount, $this->currency),
            'currency'               => $this->currency,
            'customer_email'         => $this->customer_email,
            'crypto_address'         => $this->crypto_address,
            'crypto_wallet_provider' => $this->crypto_wallet_provider,
            'billing_address'        => $this->getBillingAddressParamsStructure(),
            'shipping_address'       => $this->getShippingAddressParamsStructure()
        ];
    }
}
