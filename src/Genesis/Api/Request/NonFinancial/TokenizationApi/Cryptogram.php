<?php

namespace Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\Base\NonFinancial\TokenizationApi\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\TokenizationApiAttributes;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Cryptogram
 *
 * Get cryptogram on behalf of a token that will be used for the authorization.
 *
 * @package Genesis\Api\Request\NonFinancial\TokenizationApi
 *
 * @method string getToken()                Plain-text token value
 * @method string getTransactionReference() Unique transaction reference identifier defined by merchant
 *
 * @method $this setToken($value)                Plain-text token value
 * @method $this setTransactionReference($value) Unique transaction reference identifier defined by merchant
 */
class Cryptogram extends BaseRequest
{
    use TokenizationApiAttributes;

    /**
     * Plain-text token value
     *
     * @var string
     */
    protected $token;

    /**
     * Unique transaction reference identifier defined by merchant
     *
     * @var string
     */
    protected $transaction_reference;

    /**
     * Cryptogram constructor
     */
    public function __construct()
    {
        parent::__construct('cryptogram');
    }

    /**
     * Set the required fields
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields = [
            'consumer_id',
            'email',
            'token',
            'token_type',
            'transaction_reference'
        ];

        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Return request structure
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'consumer_id'           => $this->consumer_id,
            'email'                 => $this->email,
            'token'                 => $this->token,
            'token_type'            => $this->token_type,
            'transaction_reference' => $this->transaction_reference
        ];
    }
}
