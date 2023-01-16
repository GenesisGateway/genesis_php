<?php

namespace spec\SharedExamples\Genesis\API\Request;

use Genesis\Utils\Common;
use spec\SharedExamples\Faker;

/**
 * Trait RequestExamples
 * @package spec\SharedExamples\Genesis\API\Request
 */
trait RequestExamples
{
    private static $faker;

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->during('getDocument');
    }

    protected function testMissingRequiredParameters($requiredFields) {
        foreach ($requiredFields AS $requiredField) {
            $this->setRequestParameters();

            $this->testMissingRequiredParameter($requiredField);
        }
    }

    protected function testMissingRequiredParameter($requiredField)
    {
        $setter = 'set' . ucfirst(Common::snakeCaseToCamelCase($requiredField));
        $this->$setter(null);
        $this->shouldThrow()->during('getDocument');
    }

    /**
     * @return \Faker\Generator
     */
    protected function getFaker()
    {
        self::$faker = Faker::getInstance();

        return self::$faker;
    }

    protected function setDefaultRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));

        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp($faker->ipv4);
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));
        $this->setCustomerEmail($faker->email);
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingAddress1($faker->streetAddress);
        $this->setBillingZipCode($faker->postcode);
        $this->setBillingCity($faker->city);
        $this->setBillingState($faker->state);
    }

    protected function getExpectedFieldValueException($field)
    {
        return new \Genesis\Exceptions\InvalidArgument(
            "Please check input data for errors. '{$field}' has invalid format"
        );
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            }
        );
    }
}
