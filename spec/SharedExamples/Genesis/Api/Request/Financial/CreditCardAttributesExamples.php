<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Exceptions\ErrorParameter;
use spec\SharedExamples\Faker;

trait CreditCardAttributesExamples
{
    public function it_should_fail_without_card_number()
    {
        $this->setRequestParameters();
        $this->setCardNumber(null);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_not_trigger_deprecation_with_null_card_number()
    {
        $this->setRequestParameters();
        $this->setCardNumber(null);

        $deprecations = array();
        set_error_handler(function ($errno, $errstr) use (&$deprecations) {
            $deprecations[] = $errstr;
        }, E_DEPRECATED | E_USER_DEPRECATED);

        try {
            $this->getWrappedObject()->getDocument();
        } catch (\Exception $e) {
            // Expected ErrorParameter — we only care about deprecation notices
        }

        restore_error_handler();

        if (!empty($deprecations)) {
            throw new \Exception(
                'Deprecation notice triggered: ' . implode('; ', $deprecations)
            );
        }
    }

    public function it_should_not_trigger_deprecation_with_null_expiration_month()
    {
        $this->setRequestParameters();
        $this->setExpirationMonth(null);

        $deprecations = array();
        set_error_handler(function ($errno, $errstr) use (&$deprecations) {
            $deprecations[] = $errstr;
        }, E_DEPRECATED | E_USER_DEPRECATED);

        try {
            $this->getWrappedObject()->getDocument();
        } catch (\Exception $e) {
            // Expected ErrorParameter — we only care about deprecation notices
        }

        restore_error_handler();

        if (!empty($deprecations)) {
            throw new \Exception(
                'Deprecation notice triggered: ' . implode('; ', $deprecations)
            );
        }
    }

    public function it_should_fail_without_expiration_month()
    {
        $this->setRequestParameters();
        $this->setExpirationMonth(null);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_fail_without_expiration_year()
    {
        $this->setRequestParameters();
        $this->setExpirationYear(null);

        $this->shouldThrow(ErrorParameter::class)
            ->during('getDocument');
    }

    public function it_should_not_fail_with_invalid_cc_number_and_client_side_encryption()
    {
        $this->setRequestParameters();
        $this->setClientSideEncryption("true");
        $this->setCardHolder('42000000000000004200000000000000');
        $this->setCardNumber('42000000000000004200000000000000');
        $this->setExpirationMonth(Faker::getInstance()->word);
        $this->setExpirationYear(Faker::getInstance()->word);
        $this->setCvv('42000000000000004200000000000000');

        $this->shouldNotThrow()
            ->during('getDocument');
    }

    public function it_should_return_bool_value_for_client_side_encryption()
    {
        $this->setRequestParameters();
        $this->setClientSideEncryption('true')->getClientSideEncryption()
            ->shouldReturn(true);

        $this->shouldNotThrow()
            ->during('getDocument');
    }

    public function it_should_return_proper_class_instance_for_client_side_encryption()
    {
        $this->setRequestParameters();
        $this->setClientSideEncryption('true')->shouldReturn($this);

        $this->shouldNotThrow()
            ->during('getDocument');
    }
}
