<?php

namespace spec\Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking;

use Genesis\API\Constants\BankAccountTypes;
use Genesis\API\Constants\Transaction\Parameters\OnlineBanking\PayoutBankParameters;
use Genesis\API\Request\Financial\OnlineBankingPayments\OnlineBanking\Payout;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class PayoutSpec extends ObjectBehavior
{
    use RequestExamples;

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
        $this->setBankName($invalidBankNames);

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

    public function it_should_not_fail_with_proper_birth_date_format()
    {
        $faker = $this->getFaker();
        $this->shouldNotThrow()->during(
            'setBirthDate',
            [$faker->dateTimeThisYear()->format(Payout::BIRTH_DATE_FORMAT)]
        );
    }

    public function it_should_fail_with_invalid_birth_date_format()
    {
        $faker = $this->getFaker();
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBirthDate',
            [$faker->dateTimeThisYear()->format('d/m/Y')]
        );
    }

    public function it_should_return_string_birth_date_value()
    {
        $this->setRequestParameters();
        $this->getBirthDate()->shouldBeString();
    }

    public function it_should_not_fail_when_unset_birth_date()
    {
        $this->shouldNotThrow()->during('setBirthDate', [null]);
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
            'billing_address'
        ];

        foreach ($attributes as $attribute) {
            $this->getDocument()->shouldContain($attribute);
        }
    }

    protected function setRequestParameters()
    {
        $this->setTransactionId(Faker::getInstance()->numberBetween(1, PHP_INT_MAX));
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setNotificationUrl(Faker::getInstance()->url);
        $this->setReturnSuccessUrl(Faker::getInstance()->url);
        $this->setReturnFailureUrl(Faker::getInstance()->url);
        $this->setRemoteIp(Faker::getInstance()->ipv4);
        $this->setAmount(Faker::getInstance()->numberBetween(1, PHP_INT_MAX));

        $currency = Faker::getInstance()->randomElement(
            PayoutBankParameters::getAllowedCurrencies()
        );
        $this->setCurrency($currency);
        $this->setBankName(
            Faker::getInstance()->randomElement(
                PayoutBankParameters::getBankNamesPerCurrency($currency)
            )
        );
        
        $this->setBankAccountName(Faker::getInstance()->name);
        $this->setBankAccountNumber(mt_rand(1, PHP_INT_MAX));
        $this->setBillingFirstName(Faker::getInstance()->firstName);
        $this->setBillingLastName(Faker::getInstance()->lastName);
        $this->setBillingState(Faker::getInstance()->state);
        $this->setBillingCountry(Faker::getInstance()->countryCode);
        $this->setBankBranch(Faker::getInstance()->text(20));
        $this->setBankCode(Faker::getInstance()->text(10));
        $this->setCustomerPhone(Faker::getInstance()->phoneNumber);
        $this->setCustomerEmail(Faker::getInstance()->email);
        $this->setBankProvince(Faker::getInstance()->city);
        $this->setIdcardNumber(
            Faker::getInstance()->asciify(
                str_repeat(
                    '*',
                    mt_rand(1, Payout::ID_CARD_NUMBER_MAX_LENGTH)
                )
            )
        );
        $this->setPayerbankPhoneNumber(
            Faker::getInstance()->asciify(
                str_repeat(
                    '*',
                    mt_rand(1, Payout::PAYER_BANK_PHONE_NUMBER_MAX_LENGTH)
                )
            )
        );
        $this->setBankAccountType(
            Faker::getInstance()->randomElement(
                BankAccountTypes::getAll()
            )
        );
        $this->setDocumentType(
            Faker::getInstance()->asciify(
                str_repeat(
                    '*',
                    mt_rand(1, Payout::DOCUMENT_TYPE_MAX_LENGTH)
                )
            )
        );
        $this->setAccountId(
            Faker::getInstance()->asciify(
                str_repeat(
                    '*',
                    mt_rand(1, Payout::ACCOUNT_ID_MAX_LENGTH)
                )
            )
        );
        $this->setUserId(
            Faker::getInstance()->asciify(
                str_repeat(
                    '*',
                    mt_rand(1, Payout::USER_ID_MAX_LENGTH)
                )
            )
        );
        $this->setBirthDate(
            Faker::getInstance()->dateTimeThisYear()->format(Payout::BIRTH_DATE_FORMAT)
        );
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
