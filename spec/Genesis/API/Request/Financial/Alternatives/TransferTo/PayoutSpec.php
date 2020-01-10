<?php

namespace spec\Genesis\API\Request\Financial\Alternatives\TransferTo;

use Genesis\API\Constants\Transaction\Parameters\IdentificationTypes;
use Genesis\API\Request\Financial\Alternatives\TransferTo\Payout;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class PayoutSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Payout::class);
    }

    public function it_should_fail_when_required_parameter_missing()
    {
        $this->setRequestParameters();
        $this->testMissingRequiredParameters([
            'payer_id',
            'currency',
            'transaction_id',
            'return_success_url',
            'return_failure_url',
            'amount'
        ]);
    }

    public function it_should_fail_when_not_proper_currency_value()
    {
        $this->setRequestParameters();
        $this->setCurrency('AED');

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_invalid_customer_email_is_set()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setCustomerEmail',
            [
                $this->getFaker()->asciify('******')
            ]
        );
    }

    public function it_should_fail_when_invalid_id_type_is_set()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setIdType',
            [
                $this->getFaker()->asciify('****')
            ]
        );
    }

    public function it_should_have_proper_structure()
    {
        $this->setAllParameters();

        $this->getDocument()->shouldContain('bank_account_number');
        $this->getDocument()->shouldContain('ifs_code');
        $this->getDocument()->shouldContain('msisdn');
        $this->getDocument()->shouldContain('branch_number');
        $this->getDocument()->shouldContain('account_type');
        $this->getDocument()->shouldContain('registered_name');
        $this->getDocument()->shouldContain('registration_number');
        $this->getDocument()->shouldContain('iban');
        $this->getDocument()->shouldContain('id_type');
        $this->getDocument()->shouldContain('id_number');
        $this->getDocument()->shouldContain('billing_address');
        $this->getDocument()->shouldContain('shipping_address');
    }

    public function setRequestParameters()
    {
        $this->setDefaultRequestParameters();
        $this->setCurrency('EUR');
        $this->setPayerId(12345);
    }

    public function setAllParameters()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();

        $this->setBankAccountNumber($faker->bankAccountNumber);
        $this->setIfsCode(mt_rand(1, PHP_INT_MAX));
        $this->setMsisdn($faker->phoneNumber);
        $this->setBranchNumber(mt_rand(1, PHP_INT_MAX));
        $this->setAccountType($faker->asciify('******'));
        $this->setRegisteredName($faker->asciify('******'));
        $this->setRegistrationNumber($faker->asciify('*******'));
        $this->setIban($faker->iban(null));
        $this->setIdType(IdentificationTypes::ALIEN_REGISTRATION);
        $this->setIdNumber(mt_rand(1, PHP_INT_MAX));
        $this->setBillingFirstName($faker->firstName);
        $this->setShippingFirstName($faker->firstName);
    }
}
