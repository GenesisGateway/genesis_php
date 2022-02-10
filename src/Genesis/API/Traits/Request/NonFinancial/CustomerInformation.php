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

namespace Genesis\API\Traits\Request\NonFinancial;

use Genesis\API\Request\Base\NonFinancial\KYC\BaseRequest;
use Genesis\API\Traits\Request\Financial\BirthDateAttributes;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait CustomerInformation
 * @package Genesis\API\Traits\Request\NonFinancial
 */
trait CustomerInformation
{
    use BirthDateAttributes;

    /**
     * @var string
     */
    protected $first_name;

    /**
     * @var string
     */
    protected $middle_name;

    /**
     * @var string
     */
    protected $last_name;

    /**
     * @var string
     */
    protected $customer_email;

    /**
     * @var string
     */
    protected $address1;

    /**
     * @var string
     */
    protected $address2;

    /**
     * @var string
     */
    protected $city;

    /**
     * @var string
     */
    protected $zip_code;

    /**
     * two-letter iso codes
     *
     * @var string
     */
    protected $country;

    /**
     * @var string
     */
    protected $province;

    /**
     * @var string
     */
    protected $phone1;

    /**
     * @var string
     */
    protected $phone2;

    /**
     * @var string
     */
    protected $document_number;

    /**
     * 0 - SSN; 1 - Passport Registry; 2 - Personal ID / National ID; 3 - Identity Card; 4 - Driver License;
     * 8 - Travel Document; 12 - Residence Permit; 13 - Identity Certificate;
     * 16 - Registro Federal de Contribuyentes; 17 - Credencial de Elector; 18 - CPF
     *
     * @var string
     */
    protected $document_type;

    /**
     * F - female; M - male
     *
     * @var string
     */
    protected $gender;

    /**
     * @param $type
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setDocumentType($type)
    {
        return $this->allowedOptionsSetter(
            'document_type',
            [
                BaseRequest::DOCUMENT_TYPE_SSN,
                BaseRequest::DOCUMENT_TYPE_PASSPORT_REGISTRY,
                BaseRequest::DOCUMENT_TYPE_PERSONAL_ID,
                BaseRequest::DOCUMENT_TYPE_IDENTITY_CARD,
                BaseRequest::DOCUMENT_TYPE_DRIVER_LICENSE,
                BaseRequest::DOCUMENT_TYPE_TRAVEL_DOCUMENT,
                BaseRequest::DOCUMENT_TYPE_RESIDENCE_PERMIT,
                BaseRequest::DOCUMENT_TYPE_IDENTITY_CERTIFICATE,
                BaseRequest::DOCUMENT_TYPE_FEDERAL_REGISTER,
                BaseRequest::DOCUMENT_TYPE_ELECTRON_CREDENTIALS,
                BaseRequest::DOCUMENT_TYPE_CPF
            ],
            $type,
            'Invalid document type provided.'
        );
    }

    /**
     * @param $gender
     *
     * @return CustomerInformation
     * @throws InvalidArgument
     */
    public function setGender($gender)
    {
        return $this->allowedOptionsSetter(
            'gender',
            [
                BaseRequest::GENDER_MALE,
                BaseRequest::GENDER_FEMALE
            ],
            $gender,
            'Invalid gender provided.'
        );
    }

    /**
     * @return array
     */
    public function getCustomerInformationStructure()
    {
        return [
            'first_name'      => $this->first_name,
            'middle_name'     => $this->middle_name,
            'last_name'       => $this->last_name,
            'customer_email'  => $this->customer_email,
            'address1'        => $this->address1,
            'address2'        => $this->address2,
            'city'            => $this->city,
            'province'        => $this->province,
            'zip_code'        => $this->zip_code,
            'country'         => $this->country,
            'phone1'          => $this->phone1,
            'phone2'          => $this->phone2,
            'birth_date'      => $this->getBirthDate(),
            'document_type'   => $this->document_type,
            'document_number' => $this->document_number,
            'gender'          => $this->gender
        ];
    }
}
