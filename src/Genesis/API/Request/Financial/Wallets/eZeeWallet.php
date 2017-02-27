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

/**
 * Class eZeeWallet
 *
 * Electronic Wallet
 *
 * @package Genesis\API\Request\Financial\Wallets
 *
 * @method eZeeWallet setNotificationUrl($value) Set the URL endpoint for Genesis Notifications
 * @method eZeeWallet setReturnSuccessUrl($value) Set the URL where customer is sent to after successful payment
 * @method eZeeWallet setReturnFailureUrl($value) Set the URL where customer is sent to after un-successful payment
 * @method eZeeWallet setSourceWalletId($value) Set Email address of consumer who owns the source wallet
 * @method eZeeWallet setSourceWalletPwd($value) Set the Password of consumer who owns the source wallet
 */
// @codingStandardsIgnoreStart
class eZeeWallet extends \Genesis\API\Request\Base\Financial\Common\AbstractPayment
// @codingStandardsIgnoreEnd
{
    /**
     * URL endpoint for Genesis Notifications
     *
     * @var string
     */
    protected $notification_url;

    /**
     * URL where customer is sent to after successful payment
     *
     * @var string
     */
    protected $return_success_url;

    /**
     * URL where customer is sent to after unsuccessful payment
     *
     * @var string
     */
    protected $return_failure_url;

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
     * Return additional request attributes
     * @return array
     */
    protected function getRequestTreeStructure()
    {
        $treeStructure = parent::getRequestTreeStructure();

        return array_merge(
            $treeStructure,
            array(
                'notification_url'   => $this->notification_url,
                'return_success_url' => $this->return_success_url,
                'return_failure_url' => $this->return_failure_url,
                'source_wallet_id'   => $this->source_wallet_id,
                'source_wallet_pwd'  => $this->transform(
                    'wallet_password',
                    array(
                        $this->source_wallet_pwd
                    )
                )
            )
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = array(
            'transaction_id',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'source_wallet_id',
            'source_wallet_pwd',
        );

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);
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
