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

namespace Genesis\API\Request\Financial\Wallets;

use Genesis\API\Traits\Request\Financial\PaymentAttributes;
use Genesis\API\Traits\Request\Financial\NotificationAttributes;
use Genesis\API\Traits\Request\Financial\AsyncAttributes;

/**
 * Class eZeeWallet
 *
 * Electronic Wallet
 *
 * @package Genesis\API\Request\Financial\Wallets
 *
 * @method eZeeWallet setSourceWalletId($value) Set Email address of consumer who owns the source wallet
 * @method eZeeWallet setSourceWalletPwd($value) Set the Password of consumer who owns the source wallet
 */
// @codingStandardsIgnoreStart
class eZeeWallet extends \Genesis\API\Request\Base\Financial
// @codingStandardsIgnoreEnd
{
    use PaymentAttributes, NotificationAttributes, AsyncAttributes;

    /**
     * Email address of consumer who owns the source wallet
     *
     * @var string
     */
    protected $source_wallet_id;

    /**
     * Password of consumer who owns the source wallet, in Base64 encoded form
     *
     * @var string
     */
    protected $source_wallet_pwd;

    /**
     * Returns the Request transaction type
     * @return string
     */
    protected function getTransactionType()
    {
        return \Genesis\API\Constants\Transaction\Types::EZEEWALLET;
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
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'notification_url',
            'source_wallet_id',
            'source_wallet_pwd'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
    }

    /**
     * Return additional request attributes
     * @return array
     */
    protected function getPaymentTransactionStructure()
    {
        return [
            'amount'             => $this->transformAmount($this->amount, $this->currency),
            'currency'           => $this->currency,
            'return_success_url' => $this->return_success_url,
            'return_failure_url' => $this->return_failure_url,
            'notification_url'   => $this->notification_url,
            'source_wallet_id'   => $this->source_wallet_id,
            'source_wallet_pwd'  => $this->transformWalletPassword($this->source_wallet_pwd)
        ];
    }


    /**
     * Apply transformation:
     *
     * Encode a string in base64 or return
     * the input if already in base64
     *
     * @param string $input
     *
     * @return mixed
     */
    protected function transformWalletPassword($input = '')
    {
        if (!\Genesis\Utils\Common::isBase64Encoded($input)) {
            return base64_encode($input);
        }

        return $input;
    }
}
