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

namespace Genesis\API\Request\NonFinancial\KYC\Transaction;

use Genesis\API\Constants\NonFinancial\KYC\IndustryTypes;
use Genesis\API\Constants\NonFinancial\KYC\TransactionStatuses;
use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest;

/**
 * Class Update
 *
 * Utilize this method to update a particular transaction status so we can continue improving the data models
 * and provide the best scores and recommendations.
 *
 * @package Genesis\API\Request\NonFinancial\KYC\Transaction
 */
class Update extends BaseRequest
{
    /**
     * If this value is not provided the user email account should be complete and valid
     *
     * @var string
     */
    protected $session_id;

    /**
     * Transaction id
     *
     * @var string
     */
    protected $transaction_unique_id;

    /**
     * @var string
     */
    protected $reference_id;

    /**
     * 1-Approved;2-Pre-Auth;3-Settled;4-Void;
     * 5-Rejected internally by Negative Database or other scrubber decided to reject thetransaction;
     * 6-Declined the bank / gateway / processor rejected the transaction;7-Chargeback;
     * 8-Return;9-Pending;10-Pass Transaction validation;11-Failed ransaction validation;12-Refund;
     * 13-Approved Review;14-Abandon This status is used when the user just leaves the transaction;
     *
     * @var string
     */
    protected $status;

    /**
     * Required only if status is Reject / Decline / Chargeback / Refund / Return / Void
     *
     * @var string
     */
    protected $reason;

    /**
     * Response from processor regarding CVV check
     *
     * @var string
     */
    protected $cvv_check_result;

    /**
     * Result from processor regarding AVS check
     *
     * @var string
     */
    protected $avs_check_result;

    /**
     * Unique identifier of the processor attempted
     *
     * @var string
     */
    protected $processor_identifier;

    /**
     * Create constructor.
     */
    public function __construct()
    {
        parent::__construct('update_transaction');
    }

    /**
     * @param $status
     *
     * @return Update
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setTransactionStatus($status)
    {
        return $this->allowedOptionsSetter(
            'transaction_status',
            TransactionStatuses::getAll(),
            $status,
            'Invalid transaction status.'
        );
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'transaction_unique_id'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldsConditional = [
            'status' => [
                TransactionStatuses::REJECTED   => ['reason'],
                TransactionStatuses::DECLINED   => ['reason'],
                TransactionStatuses::CHARGEBACK => ['reason'],
                TransactionStatuses::REFUND     => ['reason'],
                TransactionStatuses::RETURN     => ['reason'],
                TransactionStatuses::VOID       => ['reason']
            ]
        ];

        $this->requiredFieldsConditional = \Genesis\Utils\Common::createArrayObject($requiredFieldsConditional);
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'session_id'            => $this->session_id,
            'transaction_unique_id' => $this->transaction_unique_id,
            'reference_id'          => $this->reference_id,
            'status'                => $this->status,
            'reason'                => $this->reason,
            'cvv_check_result'      => $this->cvv_check_result,
            'avs_check_result'      => $this->avs_check_result,
            'processor_identifier'  => $this->processor_identifier
        ];
    }
}
