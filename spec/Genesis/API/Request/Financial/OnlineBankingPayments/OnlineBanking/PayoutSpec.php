<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking;

use Genesis\API\Constants\BankAccountTypes;
use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\PayoutBankCodeParameters;
use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\PayoutBankParameters;
use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\PayoutPaymentTypesParameters;
use Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking\Payout;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;
use spec\SharedExamples\Genesis\API\Traits\Request\Financial\BirthDateAttributesExample;
use spec\SharedExamples\Genesis\API\Request\Financial\NeighborhoodAttributesExamples;

class PayoutSpec extends ObjectBehavior
{
    use RequestExamples, BirthDateAttributesExample, NeighborhoodAttributesExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(Payout::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'amount',
            'currency',
            'notification_url',
            'return_success_url',
            'return_failure_url',
            'remote_ip',
            'billing_first_name',
            'billing_last_name',
            'billing_state',
            'billing_country'
        ]);
    }

    public function it_should_fail_with_not_proper_currency_param()
    {
        $allCurrencies     = Currency::getList();
        $allowedCurrencies = PayoutBankParameters::getAllowedCurrencies();
        $invalidCurrency   = $allCurrencies[array_rand(array_diff($allCurrencies, $allowedCurrencies))];

        $this->setRequestParameters();
        $this->setCurrency($invalidCurrency);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_proper_currency_and_invalid_bank_name_for_it()
    {
        $allowedCurrencies = PayoutBankParameters::getAllowedCurrencies();
        $currency          = Faker::getInstance()->randomElement($allowedCurrencies);
        $invalidCurrency   = Faker::getInstance()->randomElement(array_diff($allowedCurrencies, [$currency]));
        $invalidBankNames  = PayoutBankParameters::getBankNamesPerCurrency($invalidCurrency);

        $this->setRequestParameters();
        $this->setCurrency($currency);
        $this->setBankName(Faker::getInstance()->randomElement($invalidBankNames));

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_invalid_id_card_number_length()
    {
        $this->testVariableStringSetter(
            'setIdCardNumber',
            Payout::ID_CARD_NUMBER_MAX_LENGTH
        );
    }

    public function it_should_not_fail_when_unset_id_card_number()
    {
        $this->shouldNotThrow()->during('setIdCardNumber', [null]);
    }

    public function it_should_fail_with_invalid_payer_bank_phone_number_length()
    {
        $this->testVariableStringSetter(
            'setPayerBankPhoneNumber',
            Payout::PAYER_BANK_PHONE_NUMBER_MAX_LENGTH
        );
    }

    public function it_should_not_fail_when_unset_payer_bank_phone_number()
    {
        $this->shouldNotThrow()->during('setPayerBankPhoneNumber', [null]);
    }

    public function it_should_fail_with_not_proper_bank_account_value()
    {
        $faker = $this->getFaker();
        $this->shouldThrow(InvalidArgument::class)
            ->during('setBankAccountType', [$faker->asciify('**')]);
    }

    public function it_should_fail_with_invalid_document_type_length()
    {
        $this->testVariableStringSetter(
            'setDocumentType',
            Payout::DOCUMENT_TYPE_MAX_LENGTH
        );
    }

    public function it_should_not_fail_when_unset_document_type()
    {
        $this->shouldNotThrow()->during('setDocumentType', [null]);
    }

    public function it_should_fail_with_invalid_account_id_length()
    {
        $this->testVariableStringSetter(
            'setAccountId',
            Payout::ACCOUNT_ID_MAX_LENGTH
        );
    }

    public function it_should_not_fail_when_unset_account_id()
    {
        $this->shouldNotThrow()->during('setAccountId', [null]);
    }

    public function it_should_fail_with_not_proper_bank_account_length()
    {
        $this->testVariableStringSetter(
            'setUserId',
            PAYOUT::USER_ID_MAX_LENGTH
        );
    }

    public function it_should_not_fail_when_unset_user_id()
    {
        $this->shouldNotThrow()->during('setUserId', [null]);
    }

    public function it_should_contain_bank_account_verification_digit_when_set()
    {
        $this->setRequestParameters();

        $digit = Faker::getInstance()->randomDigitNotNull();
        $this->setBankAccountVerificationDigit($digit);

        $this->getDocument()->shouldContain(
            "<bank_account_verification_digit>$digit</bank_account_verification_digit>"
        );
    }

    public function it_should_fail_with_not_proper_payment_type_value()
    {
        $faker = $this->getFaker();
        $this->shouldThrow(InvalidArgument::class)
            ->during('setPaymentType', [$faker->asciify('**')]);
    }

    public function it_should_fail_with_brl_currency_and_invalid_bank_name_for_it()
    {
        $currency          = 'BRL';
        $allowedCurrencies = PayoutBankParameters::getAllowedCurrencies();
        $invalidCurrency   = Faker::getInstance()->randomElement(array_diff($allowedCurrencies, [$currency]));
        $invalidBankNames  = PayoutBankParameters::getBankNamesPerCurrency($invalidCurrency);

        $this->setRequestParameters();
        $this->setCurrency($currency);
        $this->setBankCode(null);
        $this->setBankName(Faker::getInstance()->randomElement($invalidBankNames));

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_with_brl_currency_and_valid_bank_name_for_it()
    {
        $currency = 'BRL';
        $bankName = Faker::getInstance()->randomElement(PayoutBankParameters::getBankNamesPerCurrency($currency));
        $bankCode = '001';

        $this->setRequestParameters();
        $this->setCurrency($currency);
        $this->setBankName($bankName);
        $this->setBankCode($bankCode);

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_not_fail_with_brl_currency_and_bank_code()
    {
        $currency = 'BRL';
        $this->setRequestParameters();
        $this->setCurrency($currency);
        $this->setBankName(null);
        $this->setBankCode('001');

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_fail_with_brl_currency_and_no_bank_code_and_no_bank_name()
    {
        $this->setRequestParameters();
        $this->setCurrency('BRL');
        $this->setBankName(null);
        $this->setBankCode(null);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_contain_proper_structure_elements()
    {
        $this->setRequestParameters();

        $attributes = [
            'transaction_id',
            'usage',
            'remote_ip',
            'currency',
            'customer_email',
            'customer_phone',
            'notification_url',
            'return_success_url',
            'return_failure_url',
            'bank_code',
            'bank_name',
            'bank_branch',
            'bank_account_name',
            'bank_account_number',
            'bank_province',
            'id_card_number',
            'payer_bank_account_number',
            'bank_account_type',
            'document_type',
            'account_id',
            'user_id',
            'birth_date',
            'payment_type',
            'billing_address',
            'company_type',
            'company_activity',
            'incorporation_date',
            'mothers_name',
            'pix_key'
        ];

        foreach ($attributes as $attribute) {
            $this->getDocument()->shouldContain($attribute);
        }
    }

    public function it_should_set_pix_key_correctly()
    {
        $this->shouldNotThrow()->during('setPixKey', ['abcdef']);
    }

    protected function setRequestParameters()
    {
        $faker = Faker::getInstance();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setNotificationUrl($faker->url);
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setRemoteIp($faker->ipv4);
        $this->setAmount($faker->numberBetween(1, PHP_INT_MAX));

        $currency = $faker->randomElement(PayoutBankParameters::getAllowedCurrencies());
        $this->setCurrency($currency);
        $this->setBankName(
            $faker->randomElement(PayoutBankParameters::getBankNamesPerCurrency($currency))
        );
        
        $this->setBankAccountName($faker->name);
        $this->setBankAccountNumber(mt_rand(1, PHP_INT_MAX));
        $this->setBillingFirstName($faker->firstName);
        $this->setBillingLastName($faker->lastName);
        $this->setBillingState($faker->state);
        $this->setBillingCountry($faker->countryCode);
        $this->setBankBranch($faker->text(20));
        $this->setBankCode('001');
        $this->setCustomerPhone($faker->phoneNumber);
        $this->setCustomerEmail($faker->email);
        $this->setBankProvince($faker->city);
        $this->setIdcardNumber(
            $faker->asciify(str_repeat('*',mt_rand(1, Payout::ID_CARD_NUMBER_MAX_LENGTH)))
        );
        $this->setPayerbankPhoneNumber(
            $faker->asciify(
                str_repeat('*',mt_rand(1, Payout::PAYER_BANK_PHONE_NUMBER_MAX_LENGTH))
            )
        );
        $this->setBankAccountType($faker->randomElement(BankAccountTypes::getAll()));
        $this->setDocumentType(
            $faker->asciify(str_repeat('*', mt_rand(1, Payout::DOCUMENT_TYPE_MAX_LENGTH)))
        );
        $this->setAccountId(
            $faker->asciify(str_repeat('*', mt_rand(1, Payout::ACCOUNT_ID_MAX_LENGTH)))
        );
        $this->setUserId(
            $faker->asciify(str_repeat('*', mt_rand(1, Payout::USER_ID_MAX_LENGTH)))
        );
        $this->setBirthDate($faker->date($faker->randomElement(DateTimeFormat::getAll())));
        $this->setPaymentType($faker->randomElement(PayoutPaymentTypesParameters::getAll()));

        $this->setCompanyType($faker->text(10));
        $this->setCompanyActivity($faker->text(10));
        $this->setIncorporationDate($faker->date($faker->randomElement(DateTimeFormat::getAll())));
        $this->setCompanyActivity(Faker::getInstance()->text(10));
        $this->setMothersName("{$faker->firstNameFemale()} {$faker->lastName()}");
        $this->setPixKey(Faker::getInstance()->text(5));
    }

    private function testVariableStringSetter($method, $length)
    {
        $faker  = $this->getFaker();
        $string = $faker->asciify(
            str_repeat(
                '*',
                $length + 1000
            )
        );

        $this->shouldThrow(InvalidArgument::class)->during(
            $method,
            [$string]
        );
    }

    private function generateBankAccountNumber ($length = 19)
    {
        return substr(str_shuffle(str_repeat('0123456789', 5)), 1, $length);
    }
}
