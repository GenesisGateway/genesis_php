<?php

namespace spec\Genesis\Api\Request\NonFinancial\Alternatives\Alipay;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Constants\Environments;
use Genesis\Api\Constants\NonFinancial\Alternatives\Alipay\MerchantTypes;
use Genesis\Api\Constants\NonFinancial\Alternatives\Alipay\SiteTypes;
use Genesis\Api\Request;
use Genesis\Api\Request\NonFinancial\Alternatives\Alipay\RegisterMerchant;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Genesis;
use Genesis\Utils\Common;
use PhpSpec\Exception\Example\FailureException;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\MissingTerminalTokenExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;
use spec\SharedExamples\Genesis\Api\Traits\Request\NonFinancial\Alternatives\Alipay\SiteInformationAttributesExamples;

/**
 * Class RegisterMerchantSpec
 * @package spec\Genesis\Api\Request\NonFinancial\Alternatives\Alipay
 */
class RegisterMerchantSpec extends ObjectBehavior
{
    use MissingTerminalTokenExamples;
    use RequestExamples;
    use SiteInformationAttributesExamples;

    /**
     * Config is static: restore the default environment and endpoint after every example
     */
    public function letGo()
    {
        Config::setEnvironment(Environments::STAGING);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
    }

    // ------------------------------------------------------------------
    // Initialization
    // ------------------------------------------------------------------

    public function it_is_initializable()
    {
        $this->shouldHaveType(RegisterMerchant::class);
    }

    public function it_should_be_resolved_through_genesis_factory()
    {
        $genesis = new Genesis('NonFinancial\Alternatives\Alipay\RegisterMerchant');

        if (!$genesis->request() instanceof RegisterMerchant) {
            throw new FailureException(
                'Expected Genesis factory to resolve an instance of ' . RegisterMerchant::class
            );
        }
    }

    // ------------------------------------------------------------------
    // Configuration
    // ------------------------------------------------------------------

    public function it_should_use_json_format()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function it_should_use_post_method()
    {
        $this->getApiConfig('type')->shouldBe(Request::METHOD_POST);
    }

    public function it_should_use_basic_authorization()
    {
        $this->getApiConfig('authorization')->shouldBe(Request::AUTH_TYPE_BASIC);
    }

    public function it_should_use_https_protocol()
    {
        $this->getApiConfig('protocol')->shouldBe(Request::PROTOCOL_HTTPS);
        $this->getApiConfig('protocol')->shouldBe('https');
    }

    public function it_should_use_https_port()
    {
        $this->getApiConfig('port')->shouldBe(Request::PORT_HTTPS);
        $this->getApiConfig('port')->shouldBe(443);
    }

    // ------------------------------------------------------------------
    // Endpoints
    // ------------------------------------------------------------------

    public function it_should_build_staging_emerchantpay_url()
    {
        $this->assertServiceUrl(
            Environments::STAGING,
            Endpoints::EMERCHANTPAY,
            'https://staging.gate.emerchantpay.net:443/v1/alipay/register_merchant/123456/'
        );
    }

    public function it_should_build_production_emerchantpay_url()
    {
        $this->assertServiceUrl(
            Environments::PRODUCTION,
            Endpoints::EMERCHANTPAY,
            'https://gate.emerchantpay.net:443/v1/alipay/register_merchant/123456/'
        );
    }

    public function it_should_build_staging_ecomprocessing_url()
    {
        $this->assertServiceUrl(
            Environments::STAGING,
            Endpoints::ECOMPROCESSING,
            'https://staging.gate.e-comprocessing.net:443/v1/alipay/register_merchant/123456/'
        );
    }

    public function it_should_build_production_ecomprocessing_url()
    {
        $this->assertServiceUrl(
            Environments::PRODUCTION,
            Endpoints::ECOMPROCESSING,
            'https://gate.e-comprocessing.net:443/v1/alipay/register_merchant/123456/'
        );
    }

    // ------------------------------------------------------------------
    // Required parameters and enum values
    // ------------------------------------------------------------------

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters($this->getAlwaysRequiredFields());
    }

    public function it_should_throw_error_parameter_when_missing_required_params()
    {
        foreach ($this->getAlwaysRequiredFields() as $field) {
            $this->setRequestParameters();

            $setter = 'set' . ucfirst(Common::snakeCaseToCamelCase($field));
            $this->$setter(null);

            $this->shouldThrow(ErrorParameter::class)->during('getDocument');
        }
    }

    public function it_should_fail_with_invalid_merchant_type()
    {
        foreach (['INVALID', 'enterprise', 'individual'] as $invalidValue) {
            $this->setRequestParameters();
            $this->setMerchantType($invalidValue);

            $this->shouldThrow(ErrorParameter::class)->during('getDocument');
        }
    }

    public function it_should_fail_with_invalid_site_information_type()
    {
        foreach (['INVALID', 'web', 'app'] as $invalidValue) {
            $this->setRequestParameters();
            $this->setSiteInformationType($invalidValue);

            $this->shouldThrow(ErrorParameter::class)->during('getDocument');
        }
    }

    public function it_should_not_fail_with_valid_enum_values()
    {
        foreach (SiteTypes::getAll() as $siteType) {
            $this->setRequestParameters();
            $this->setSiteInformationType($siteType);
            $this->shouldNotThrow()->during('getDocument');

            $this->setIndividualRequestParameters();
            $this->setSiteInformationType($siteType);
            $this->shouldNotThrow()->during('getDocument');
        }
    }

    // ------------------------------------------------------------------
    // Conditional requirements by merchant type
    // ------------------------------------------------------------------

    public function it_should_fail_when_enterprise_conditional_field_is_missing()
    {
        foreach (['shareholder_id', 'shareholder_name', 'registration_number'] as $field) {
            $this->setRequestParameters();

            $setter = 'set' . ucfirst(Common::snakeCaseToCamelCase($field));
            $this->$setter(null);

            $this->shouldThrow(ErrorParameter::class)->during('getDocument');
        }
    }

    public function it_should_not_fail_when_enterprise_without_representative_fields()
    {
        $this->setRequestParameters();
        $this->setRepresentativeName(null);
        $this->setRepresentativeId(null);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_when_individual_conditional_field_is_missing()
    {
        foreach (['representative_name', 'representative_id'] as $field) {
            $this->setIndividualRequestParameters();

            $setter = 'set' . ucfirst(Common::snakeCaseToCamelCase($field));
            $this->$setter(null);

            $this->shouldThrow(ErrorParameter::class)->during('getDocument');
        }
    }

    public function it_should_not_fail_when_individual_without_registration_number()
    {
        $this->setIndividualRequestParameters();
        $this->setRegistrationNumber(null);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_pass_through_shareholder_fields_for_individual()
    {
        $this->setIndividualRequestParameters();
        $this->setShareholderId('1234567');
        $this->setShareholderName('John Doe');

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain('"shareholder_id":"1234567"');
        $this->getDocument()->shouldContain('"shareholder_name":"John Doe"');
    }

    // ------------------------------------------------------------------
    // Length, format and null-clearing
    // ------------------------------------------------------------------

    public function it_should_accept_values_with_max_length()
    {
        foreach ($this->getFieldMaxLengths() as $field => $maxLength) {
            $value  = $this->buildValidValue($field, $maxLength);
            $setter = $this->getSetterName($field);
            $getter = $this->getGetterName($field);

            $this->shouldNotThrow()->during($setter, [$value]);
            $this->$getter()->shouldBe($value);
        }
    }

    public function it_should_fail_with_values_exceeding_max_length()
    {
        foreach ($this->getFieldMaxLengths() as $field => $maxLength) {
            $this->shouldThrow(new InvalidArgument("$field value must be max $maxLength chars long."))
                ->during($this->getSetterName($field), [$this->buildValidValue($field, $maxLength + 1)]);
        }
    }

    public function it_should_validate_phone_number_format()
    {
        $this->assertFieldFormat(
            ['contact_number', 'customer_service_number'],
            ['+359(2)123-456', '0888123456'],
            ['abc123', '+359 2 123']
        );
    }

    public function it_should_validate_settlement_number_format()
    {
        $this->assertFieldFormat(
            ['settlement_number'],
            ['ABC123def'],
            ['ABC-123', 'ABC 123', 'ABC_123']
        );
    }

    public function it_should_validate_email_format()
    {
        $this->assertFieldFormat(
            ['contact_email', 'customer_service_email'],
            ['john@example.com'],
            ['invalid_email']
        );
    }

    public function it_should_clear_fields_with_empty_values()
    {
        foreach (array_keys($this->getFieldMaxLengths()) as $field) {
            $setter = $this->getSetterName($field);
            $getter = $this->getGetterName($field);

            foreach ([null, ''] as $emptyValue) {
                $this->$setter($this->buildValidValue($field, 30));
                $this->$getter()->shouldNotBe(null);

                $this->shouldNotThrow()->during($setter, [$emptyValue]);
                $this->$getter()->shouldBe(null);
            }
        }
    }

    // ------------------------------------------------------------------
    // Payload
    // ------------------------------------------------------------------

    public function it_should_build_full_enterprise_document()
    {
        $this->setMerchantType(MerchantTypes::ENTERPRISE);
        $this->setSiteInformationType(SiteTypes::WEB);
        $this->setSiteInformationUrl('https://Example.com/Shop');
        $this->setSiteInformationName('My Shop Name');
        $this->setShareholderId('SH-1234567');
        $this->setShareholderName('John Doe');
        $this->setRegistrationNumber('Reg-7654321');
        $this->setRepresentativeName('Jane Doe');
        $this->setRepresentativeId('Rep-112233');
        $this->setSettlementNumber('AbC123dEf');
        $this->setContactNumber('+359(2)123-456');
        $this->setContactEmail('Contact@Example.com');
        $this->setCustomerServiceNumber('0888-123-456');
        $this->setCustomerServiceEmail('Support@Example.com');

        $expected = [
            'merchant_type'           => 'ENTERPRISE',
            'site_information'        => [
                'type' => 'WEB',
                'url'  => 'https://Example.com/Shop',
                'name' => 'My Shop Name',
            ],
            'shareholder_id'          => 'SH-1234567',
            'shareholder_name'        => 'John Doe',
            'registration_number'     => 'Reg-7654321',
            'representative_name'     => 'Jane Doe',
            'representative_id'       => 'Rep-112233',
            'settlement_number'       => 'AbC123dEf',
            'contact_number'          => '+359(2)123-456',
            'contact_email'           => 'Contact@Example.com',
            'customer_service_number' => '0888-123-456',
            'customer_service_email'  => 'Support@Example.com',
        ];

        $this->getDocument()->shouldBe(json_encode($expected));
    }

    public function it_should_build_minimal_individual_document()
    {
        $this->setMinimalIndividualRequestParameters();

        $this->getDocument()->shouldBe(json_encode($this->getMinimalIndividualDocument()));
    }

    public function it_should_omit_unset_optional_keys()
    {
        $this->setMinimalIndividualRequestParameters();

        $document = $this->getDocument();

        foreach (
            [
                'settlement_number',
                'contact_email',
                'customer_service_number',
                'customer_service_email',
                'registration_number',
                'shareholder_id',
                'shareholder_name',
            ] as $key
        ) {
            $document->shouldNotContain("\"$key\"");
        }

        // site_information.name is omitted: the object holds only type and url
        $document->shouldContain('"site_information":{"type":"WEB","url":"https:\/\/example.com"}');
    }

    // ------------------------------------------------------------------
    // Helpers
    // ------------------------------------------------------------------

    /**
     * Minimal INDIVIDUAL request with fixed values
     */
    protected function setMinimalIndividualRequestParameters()
    {
        $this->setMerchantType(MerchantTypes::INDIVIDUAL);
        $this->setSiteInformationType(SiteTypes::WEB);
        $this->setSiteInformationUrl('https://example.com');
        $this->setRepresentativeName('Jane Doe');
        $this->setRepresentativeId('ID-998877');
        $this->setContactNumber('+359(2)123-456');
    }

    /**
     * Expected document for setMinimalIndividualRequestParameters()
     *
     * @return array
     */
    protected function getMinimalIndividualDocument()
    {
        return [
            'merchant_type'       => 'INDIVIDUAL',
            'site_information'    => [
                'type' => 'WEB',
                'url'  => 'https://example.com',
            ],
            'representative_name' => 'Jane Doe',
            'representative_id'   => 'ID-998877',
            'contact_number'      => '+359(2)123-456',
        ];
    }

    /**
     * Max lengths of the fields with explicit (validating) setters
     *
     * @return array
     */
    protected function getFieldMaxLengths()
    {
        return [
            'shareholder_id'          => 128,
            'registration_number'     => 128,
            'representative_id'       => 128,
            'contact_email'           => 128,
            'customer_service_email'  => 128,
            'shareholder_name'        => 64,
            'representative_name'     => 64,
            'settlement_number'       => 64,
            'contact_number'          => 64,
            'customer_service_number' => 64,
        ];
    }

    /**
     * Builds a value of exactly $length characters that is valid for the field's format
     * ($length must be at least 10 for email fields)
     *
     * @param string $field
     * @param int    $length
     *
     * @return string
     */
    protected function buildValidValue($field, $length)
    {
        switch ($field) {
            case 'contact_number':
            case 'customer_service_number':
                return str_repeat('1', $length);
            case 'contact_email':
            case 'customer_service_email':
                return $this->buildEmail($length);
            default:
                return str_repeat('a', $length);
        }
    }

    /**
     * Builds a valid email address of exactly $length characters (min 10).
     * The local part is limited to 64 characters and domain labels to 63, so the
     * domain is padded in two labels: {local}@{label}.{label}.com
     *
     * @param int $length
     *
     * @return string
     */
    protected function buildEmail($length)
    {
        $suffix      = '.com';
        $localLength = min(60, $length - 9);
        $domainChars = $length - $localLength - 1 - strlen($suffix);
        $firstLabel  = (int) floor(($domainChars - 1) / 2);
        $secondLabel = $domainChars - 1 - $firstLabel;

        return str_repeat('a', $localLength) . '@' .
            str_repeat('b', $firstLabel) . '.' . str_repeat('c', $secondLabel) . $suffix;
    }

    /**
     * Asserts that every field accepts the valid values and rejects the invalid ones at set-time
     *
     * @param array $fields
     * @param array $validValues
     * @param array $invalidValues
     */
    protected function assertFieldFormat(array $fields, array $validValues, array $invalidValues)
    {
        foreach ($fields as $field) {
            $setter = $this->getSetterName($field);
            $getter = $this->getGetterName($field);

            foreach ($validValues as $value) {
                $this->shouldNotThrow()->during($setter, [$value]);
                $this->$getter()->shouldBe($value);
            }

            foreach ($invalidValues as $value) {
                $this->shouldThrow(InvalidArgument::class)->during($setter, [$value]);
            }
        }
    }

    /**
     * @param string $field
     *
     * @return string
     */
    protected function getSetterName($field)
    {
        return 'set' . ucfirst(Common::snakeCaseToCamelCase($field));
    }

    /**
     * @param string $field
     *
     * @return string
     */
    protected function getGetterName($field)
    {
        return 'get' . ucfirst(Common::snakeCaseToCamelCase($field));
    }

    /**
     * Fields required regardless of the merchant type
     *
     * @return array
     */
    protected function getAlwaysRequiredFields()
    {
        return [
            'merchant_type',
            'site_information_type',
            'site_information_url',
            'contact_number',
        ];
    }

    /**
     * Config must be set before the first call on $this: the URL is built in the
     * constructor and phpspec instantiates the subject lazily
     *
     * @param string $environment
     * @param string $endpoint
     * @param string $expectedUrl
     */
    protected function assertServiceUrl($environment, $endpoint, $expectedUrl)
    {
        Config::setToken('123456');
        Config::setEndpoint($endpoint);
        Config::setEnvironment($environment);

        $this->setRequestParameters();
        $this->getDocument();

        $this->getApiConfig('url')->shouldBe($expectedUrl);
    }

    /**
     * Valid ENTERPRISE request (used by the shared examples)
     */
    protected function setRequestParameters()
    {
        $this->setCommonRequestParameters();

        $faker = $this->getFaker();

        $this->setMerchantType(MerchantTypes::ENTERPRISE);
        $this->setShareholderId($faker->numerify('#######'));
        $this->setShareholderName($faker->name);
        $this->setRegistrationNumber($faker->numerify('#######'));
    }

    /**
     * Valid INDIVIDUAL request
     */
    protected function setIndividualRequestParameters()
    {
        $this->setCommonRequestParameters();

        $faker = $this->getFaker();

        $this->setMerchantType(MerchantTypes::INDIVIDUAL);
        $this->setRepresentativeName($faker->name);
        $this->setRepresentativeId($faker->numerify('#######'));
    }

    /**
     * Parameters required regardless of the merchant type
     */
    protected function setCommonRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setSiteInformationType(SiteTypes::WEB);
        $this->setSiteInformationUrl('https://example.com');
        $this->setContactNumber($faker->numerify('+359(2)###-###'));
    }
}
