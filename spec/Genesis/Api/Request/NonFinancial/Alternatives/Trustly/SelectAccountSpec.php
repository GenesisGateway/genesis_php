<?php

namespace spec\Genesis\Api\Request\NonFinancial\Alternatives\Trustly;

use Genesis\Api\Constants\DateTimeFormat;
use Genesis\Api\Request\NonFinancial\Alternatives\Trustly\SelectAccount;
use Genesis\Builder;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Country;
use DateTime;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

/**
 * Class SelectAccountSpec
 * @package spec\Genesis\Api\Request\NonFinancial\Alternatives\Trustly
 */
class SelectAccountSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(SelectAccount::class);
    }

    public function it_should_have_correct_request_type()
    {
        $this->getConfig()->shouldHaveKeyWithValue('format', Builder::JSON);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'country',
            'first_name',
            'last_name',
            'ip_address',
            'mobile_phone',
            'national_id',
            'birth_date',
            'success_url',
            'failure_url',
            'user_id',
            'unique_id',
            'locale',
            'email'
        ]);
    }

    public function it_should_fail_with_invalid_email()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setEmail', ['invalid_email']);
    }

    public function it_should_fail_with_invalid_country()
    {
        $this->setRequestParameters();
        $this->setCountry(`invalid_country`);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_set_birth_date()
    {
        $faker = $this->getFaker();

        $dateFormat = $faker->randomElement(DateTimeFormat::getAll());
        $dateString = $faker->date($dateFormat);
        $dateTime   = DateTime::createFromFormat($dateFormat, $dateString);

        $this->shouldNotThrow()->during(
            'setBirthDate',
            [
                $dateTime->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS)
            ]
        );

        $this->getBirthDate()->shouldBe($dateTime->format(DateTimeFormat::YYYY_MM_DD_ISO_8601));
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setCountry($faker->randomElement(Country::getList()));
        $this->setFirstName($faker->firstName);
        $this->setLastName($faker->lastName);
        $this->setIpAddress($faker->ipv4());
        $this->setEmail($faker->email());
        $this->setMobilePhone($faker->phoneNumber);
        $this->setNationalId($faker->numerify);
        $this->setBirthDate($faker->date());
        $this->setSuccessUrl($faker->url());
        $this->setFailureUrl($faker->url());
        $this->setUserId($faker->numerify());
        $this->setUniqueId($faker->numerify());
        $this->setLocale($faker->locale());
    }
}
