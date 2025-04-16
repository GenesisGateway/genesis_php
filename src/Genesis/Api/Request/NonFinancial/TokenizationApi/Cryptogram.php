<?php

namespace Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\Base\NonFinancial\TokenizationApi\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\TokenizationApiAttributes;
use Genesis\Utils\Common as CommonUtils;

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
            'token_type'
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
            'consumer_id' => $this->consumer_id,
            'email'       => $this->email,
            'token'       => $this->token,
            'token_type'  => $this->token_type
        ];
    }
}
