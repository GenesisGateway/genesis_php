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

namespace Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration;

use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest;
use Genesis\API\Traits\RestrictedSetter;

/**
 * Class Update
 *
 * Update the customer registration to be able to pass on the latest status required so we can continue improving
 * the data models and provide the best scores and recommendations possible.
 *
 * @package Genesis\API\Request\NonFinancial\KYC\ConsumerRegistration
 */
class Update extends BaseRequest
{
    use RestrictedSetter;

    /**
     * Unique id returned by corresponding transaction
     *
     * @var string
     */
    protected $reference_id;

    /**
     * 0 - Undefined; 1 - Review; 2 - Denied; 3 - Approved;
     *
     * @var string
     */
    protected $profile_current_status;

    /**
     * Required only if status is Reject / Decline / Chargeback / Refund / Return / Void
     *
     * @var string
     */
    protected $status_reason;

    /**
     * Update constructor.
     */
    public function __construct()
    {
        parent::__construct('update_consumer');
    }

    /**
     * @param $status
     *
     * @return Update
     * @throws \Genesis\Exceptions\InvalidArgument
     */
    public function setProfileCurrentStatus($status)
    {
        return $this->allowedOptionsSetter(
            'profile_current_status',
            [
                self::PROFILE_CURRENT_STATUS_UNDEFINED,
                self::PROFILE_CURRENT_STATUS_REVIEW,
                self::PROFILE_CURRENT_STATUS_DENIED,
                self::PROFILE_CURRENT_STATUS_APPROVED
            ],
            $status,
            'Invalid profile current status.'
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
            'reference_id',
            'profile_current_status'
        ];

        $this->requiredFields = \Genesis\Utils\Common::createArrayObject($requiredFields);

        $requiredFieldsConditional = [
            'profile_current_status' => [
                self::PROFILE_CURRENT_STATUS_DENIED => [
                    'status_reason'
                ]
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
            'reference_id'           => $this->reference_id,
            'profile_current_status' => $this->profile_current_status,
            'status_reason'          => $this->status_reason
        ];
    }
}
