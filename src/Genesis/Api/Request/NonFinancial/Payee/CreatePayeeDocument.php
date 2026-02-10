<?php

namespace Genesis\Api\Request\NonFinancial\Payee;

use Genesis\Api\Constants\NonFinancial\Payee\PayeeDocumentTypes;
use Genesis\Api\Request\Base\NonFinancial\Payee\BaseRequest;
use Genesis\Api\Traits\Request\NonFinancial\PayeeAttributes;
use Genesis\Exceptions\EnvironmentNotSet;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class CreatePayeeDocument
 *
 * Create a Payee Document
 *
 * @package Genesis\Api\Request\NonFinancial\Payee
 *
 * @method string getPayeeUniqueId()
 *      Returns the unique identifier of the Payee
 * @method $this  setPayeeUniqueId($value)
 *      Sets the unique identifier of the Payee
 * @method string getDocumentDocumentType()
 *      Returns the type of the Document being uploaded. Possible values are defined in the PayeeDocumentTypes class.
 * @method $this  setDocumentDocumentType($value)
 *      Sets the type of the Document being uploaded. Possible values are defined in the PayeeDocumentTypes class.
 * @method string getDocumentFile()
 *      Returns the Document file, base64 encoded. The file must be in PDF, PNG or JPG format.
 *      Maximum file size is 10 MB. The file string begins with the mime type, for example:
 *      "data:application/pdf;base64, JVBERi0xLjQKJcfs...". Mind the space after the comma.
 * @method $this  setDocumentFile($value)
 *      Sets the Document file, base64 encoded. The file must be in PDF, PNG or JPG format.
 *      Maximum file size is 10 MB. The file string begins with the mime type, for example:
 *      "data:application/pdf;base64, JVBERi0xLjQKJcfs...". Mind the space after the comma.
 *
 */
class CreatePayeeDocument extends BaseRequest
{
    use PayeeAttributes;

    const REQUEST_PATH = 'payee/:payee_unique_id/documents';

    /**
     * The type of the Document being uploaded. Possible values are defined in the PayeeDocumentTypes class.
     *
     * @var string
     */
    protected $document_document_type;

    /**
     * The Document file, base64 encoded. The file must be in PDF, PNG or JPG format. Maximum file size is 10 MB.
     * The file string begins with the mime type, for example: "data:application/pdf;base64, JVBERi0xLjQKJcfs...".
     * Mind the space after the comma.
     *
     * @var string Base64 encoded file content
     */
    protected $document_file;

    /**
     * CreatePayeeDocument constructor.
     */
    public function __construct()
    {
        parent::__construct(self::REQUEST_PATH);
    }

    /**
     * Updates the request path with payee_unique_id and query parameters.
     *
     * @return void
     *
     * @throws EnvironmentNotSet
     */
    protected function updateRequestPath()
    {
        $this->setRequestPath(
            str_replace(
                ':payee_unique_id',
                (string)$this->payee_unique_id,
                self::REQUEST_PATH
            )
        );
    }

    /**
     * Sets the required fields for the request.
     *
     * @return void
     */
    protected function setRequiredFields()
    {
        $requiredFields       = [
            'payee_unique_id',
            'document_document_type',
            'document_file',
        ];
        $this->requiredFields = CommonUtils::createArrayObject($requiredFields);

        $requiredFieldValues       = [
            'document_document_type' => PayeeDocumentTypes::getAll(),
        ];
        $this->requiredFieldValues = CommonUtils::createArrayObject($requiredFieldValues);
    }

    /**
     * Returns the request structure.
     *
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'document' => [
                'document_type' => $this->document_document_type,
                'file'          => $this->document_file,
            ]
        ];
    }
}
