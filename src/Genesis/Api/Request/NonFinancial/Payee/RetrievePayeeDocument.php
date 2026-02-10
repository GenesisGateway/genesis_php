<?php

namespace Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\PayeeAttributes;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class RetrievePayeeDocument
 *
 * Retrieve the details of a specific Payee Document.
 *
 * @package Genesis\Api\Request\NonFinancial\Payee
 *
 * @method string getPayeeUniqueId()    Returns the unique identifier of the Payee
 * @method string getDocumentUniqueId() Returns the unique identifier of the Payee document
 *
 */
class RetrievePayeeDocument extends BaseRequest
{
    use PayeeAttributes;

    const REQUEST_PATH = 'payee/:payee_unique_id/documents/:document_unique_id';

    /**
     * The unique identifier of the Payee document.
     *
     * @var string
     */
    protected $document_unique_id;

    /**
     * ListPayeeOwners constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Sets the unique identifier of the Payee document.
     *
     * @param string $value
     *
     * @return $this
     *
     * @throws EnvironmentNotSet
     */
    public function setDocumentUniqueId($value)
    {
        $this->document_unique_id = $value;
        $this->updateRequestPath();

        return $this;
    }

    /**
     * Updates the request path with payee_unique_id and document_unique_id.
     *
     * @return void
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $path = str_replace(
            ':payee_unique_id',
            (string)$this->payee_unique_id,
            self::REQUEST_PATH
        );

        $this->setRequestPath(
            str_replace(
                ':document_unique_id',
                (string)$this->document_unique_id,
                $path
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
        $requiredFields       = [
            'payee_unique_id',
            'document_unique_id'
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);
    }

    /**
     * Configures a Secured Post Request with JSON body
     *
     * @return void
     */
    protected function initJsonConfiguration()
    {
        $this->setGetRequest();
    }

    /**
     * Returns an empty request structure (GET requests don't need a body).
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [];
    }
}
