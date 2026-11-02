<?php

namespace Genesis\Api\Request\NonFinancial\TokenizationApi;

use Genesis\Api\Request\Base\NonFinancial\TokenizationApi\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\TokenizationApiAttributes;
use Genesis\Exceptions\InvalidArgument;
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
 * @method bool|null getSchemeTokenized()    Whether the cryptogram is requested for a scheme-tokenized card
 *
 * @method $this setToken($value)                Plain-text token value
 * @method $this setTransactionReference($value) Unique transaction reference identifier defined by merchant
 * @method $this setSchemeTokenized($value)      Request a scheme-tokenized cryptogram (Card Scheme Tokenization)
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
     * Indicates that the cryptogram is requested for a scheme-tokenized card.
     * Sent only when explicitly set; omitted otherwise.
     *
     * @var bool|null
     */
    protected $scheme_tokenized;

    /**
     * Cryptogram constructor
     */
    public function __construct()
    {
        parent::__construct('cryptogram');
    }

    /**
     * Set whether a scheme-tokenized cryptogram is requested (Card Scheme Tokenization)
     *
     * @param bool|string|int $value Boolean or a value recognized as boolean (e.g. 'true', 'no', 1, 0)
     *
     * @return $this
     * @throws InvalidArgument When the value is not recognized as a boolean
     */
    public function setSchemeTokenized($value)
    {
        $filtered = CommonUtils::filterBoolean($value);

        if (!is_bool($filtered)) {
            throw new InvalidArgument('Invalid value given for scheme_tokenized. Boolean value is expected.');
        }

        $this->scheme_tokenized = $filtered;

        return $this;
    }

    /**
     * Return the parameters which may hold empty (but not null) values, e.g. scheme_tokenized = false
     * Example value:
     * array(
     *     'class_property' => 'request_structure_key'
     * )
     *
     * @return array
     */
    protected function allowedEmptyNotNullFields()
    {
        return [
            'scheme_tokenized' => 'scheme_tokenized'
        ];
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
            'transaction_reference' => $this->transaction_reference,
            'scheme_tokenized'      => $this->scheme_tokenized
        ];
    }
}
