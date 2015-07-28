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
 */
// @codingStandardsIgnoreStart
class eZeeWallet extends \Genesis\API\Request
// @codingStandardsIgnoreEnd
{
    /**
     * Unique transaction id defined by mer-chant
     *
     * @var string
     */
    protected $transaction_id;

    /**
     * Description of the transaction for later use
     *
     * @var string
     */
    protected $usage;

    /**
     * IPv4 address of customer
     *
     * @var string
     */
    protected $remote_ip;

    /**
     * Amount of transaction in minor currency unit
     *
     * @var int
     */
    protected $amount;

    /**
     * Currency code in ISO-4217
     *
     * @var string
     */
    protected $currency;

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
     * Set the per-request configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        $this->config = \Genesis\Utils\Common::createArrayObject(array(
                'protocol' => 'https',
                'port'     => 443,
                'type'     => 'POST',
                'format'   => 'xml',
            ));

        $this->setApiConfig('url', $this->buildRequestURL('gateway', 'process', \Genesis\Config::getToken()));
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
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = array(
            'payment_transaction' => array(
                'transaction_type'   => \Genesis\API\Constants\Transaction\Types::EZEEWALLET,
                'transaction_id'     => $this->transaction_id,
                'usage'              => $this->usage,
                'remote_ip'          => $this->remote_ip,
                'amount'             => $this->transform(
                    'amount',
                    array(
                        $this->amount,
                        $this->currency,
                    )
                ),
                'currency'           => $this->currency,
                'return_success_url' => $this->return_success_url,
                'return_failure_url' => $this->return_failure_url,
                'source_wallet_id'   => $this->source_wallet_id,
                'source_wallet_pwd'  => $this->transform(
                    'wallet_password',
                    array(
                        $this->source_wallet_pwd
                    )
                ),
            )
        );

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
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
