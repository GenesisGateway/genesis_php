<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking;

use Genesis\API\Constants\Banks;
use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\BankCodeParameters;
use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\PaymentTypes;
use Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking\Payin;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Traits\Request\DocumentAttributesExample;

class PayinSpec extends ObjectBehavior
{
    use RequestExamples, DocumentAttributesExample;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Payin::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'remote_ip',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'bank_code'
        ]);
    }

    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $allowedCurrencies = BankCodeParameters::getAllowedCurrencies();
        $currency          = $allowedCurrencies[array_rand($allowedCurrencies)];
        $allowedBanks      = BankCodeParameters::getBankCodesPerCurrency($currency);
        $bankCode          = $allowedBanks[array_rand($allowedBanks)];

        $this->setBankCode($bankCode);
        $this->setCurrency($currency);
        $this->setBillingCountry($this->getFaker()->countryCode);
    }

    public function it_should_fail_when_wrong_currency_param()
    {
        $this->setRequestParameters();

        $wrongCurrencies = array_diff(Currency::getList(), BankCodeParameters::getAllowedCurrencies());

        $this->setCurrency($wrongCurrencies[array_rand($wrongCurrencies)]);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_required_bank_code_is_missing()
    {
        $this->setRequestParameters();
        $this->setBankCode('');
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_allowed_currency_and_invalid_bank_code()
    {
        $this->setRequestParameters();

        $allowedCurrencies = BankCodeParameters::getAllowedCurrencies();
        $currency          = $allowedCurrencies[array_rand($allowedCurrencies)];

        $allowedBanks      = BankCodeParameters::getBankCodesPerCurrency($currency);
        $invalidBankCodes  = array_diff(Banks::getAll(), $allowedBanks);
        $invalidBankCode   = $invalidBankCodes[array_rand($invalidBankCodes)];

        $this->setCurrency($currency);
        $this->setBankCode($invalidBankCode);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_state_for_US_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('US');
        $this->setBillingState(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_missing_billing_state_for_CA_param()
    {
        $this->setRequestParameters();
        $this->setBillingCountry('CA');
        $this->setBillingState(null);
        $this->shouldThrow()->during('getDocument');
    }

    public function it_should_fail_when_invalid_payment_type_param()
    {
        $this->shouldThrow()->during('setPaymentType', ['fake_type']);
    }

    public function it_should_succeed_when_valid_payment_type_param()
    {
        $paymentType = Faker::getInstance()->randomElement(PaymentTypes::getAll());
        $this->shouldNotThrow()->during('setPaymentType', [$paymentType]);
    }

    public function it_should_have_proper_structure()
    {
        $faker = $this->getFaker();

        $this->setRequestParameters();

        $this->setCustomerPhone($faker->phoneNumber);
        $this->setPaymentType(PaymentTypes::NETBANKING);
        $this->setCurrency('MYR');
        $this->setBankCode(Banks::FPX_ABB);
        $this->setBillingCountry('IN');
        $this->setDocumentId('ABCDE1234F');
        $this->setShippingFirstName($faker->firstName);
        $this->setVirtualPaymentAddress('someone@example');
        $this->setConsumerReference('someone@example');

        $attributes = [
            'transaction_id',
            'usage',
            'remote_ip',
            'amount',
            'currency',
            'bank_code',
            'return_success_url',
            'return_failure_url',
            'customer_email',
            'customer_phone',
            'payment_type',
            'document_id',
            'billing_address',
            'shipping_address',
            'virtual_payment_address',
            'consumer_reference',
            'country'
        ];

        foreach ($attributes as $attribute) {
            $this->getDocument()->shouldContain($attribute);
        }
    }
}
