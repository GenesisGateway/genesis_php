<?php

/**
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
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace spec\Genesis\Api\Request\NonFinancial\Kyc\BankAccount;

use Genesis\Api\Constants\Endpoints;
use Genesis\Api\Constants\NonFinancial\Kyc\BankAccountTypes;
use Genesis\Api\Request\NonFinancial\Kyc\BankAccount\BankAccountVerification;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

class BankAccountVerificationSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(BankAccountVerification::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'bank_account_name',
            'bank_account_number',
            'bank_account_type',
            'sort_code'
        ]);
    }

    public function it_can_build_structure()
    {
        $this->setRequestParameters();
        $this->getDocument()->shouldNotBeEmpty();
    }

    public function it_should_build_expected_payload()
    {
        $faker = Faker::getInstance();

        $bankAccountName   = $faker->name;
        $bankAccountNumber = $faker->regexify('[0-9]{8}');
        $bankAccountType   = $faker->randomElement(BankAccountTypes::getAll());
        $sortCode          = $faker->regexify('[0-9]{6}');
        $referenceId       = $faker->regexify('[A-Za-z0-9]{32}');

        $this->setBankAccountName($bankAccountName);
        $this->setBankAccountNumber($bankAccountNumber);
        $this->setBankAccountType($bankAccountType);
        $this->setSortCode($sortCode);
        $this->setReferenceId($referenceId);

        $document = $this->getDocument();
        $document->shouldContain('bank_account_name');
        $document->shouldContain($bankAccountName);
        $document->shouldContain('bank_account_number');
        $document->shouldContain($bankAccountNumber);
        $document->shouldContain('bank_account_type');
        $document->shouldContain($bankAccountType);
        $document->shouldContain('sort_code');
        $document->shouldContain($sortCode);
        $document->shouldContain('reference_id');
        $document->shouldContain($referenceId);
    }

    public function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_set_correct_url()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setRequestParameters();

        $this->getDocument();
        $this->getApiConfig('url')->shouldContain(
            'https://staging.kyc.emerchantpay.net:443/api/v1/bank_account_verification'
        );
    }

    public function it_should_fail_when_bank_account_type_not_valid()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setBankAccountType', ['Invalid']);
    }

    public function it_should_fail_when_bank_account_number_too_long()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setBankAccountNumber',
            [Faker::getInstance()->regexify('[0-9]{9}')]
        );
    }

    public function it_should_fail_when_sort_code_too_long()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setSortCode',
            [Faker::getInstance()->regexify('[0-9]{7}')]
        );
    }

    public function it_should_fail_when_reference_id_too_long()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setReferenceId',
            [Faker::getInstance()->regexify('[A-Za-z0-9]{33}')]
        );
    }

    protected function setRequestParameters()
    {
        $faker = Faker::getInstance();

        $this->setBankAccountName($faker->name);
        $this->setBankAccountNumber($faker->regexify('[0-9]{8}'));
        $this->setBankAccountType($faker->randomElement(BankAccountTypes::getAll()));
        $this->setSortCode($faker->regexify('[0-9]{6}'));
        $this->setReferenceId($faker->regexify('[A-Za-z0-9]{32}'));
    }
}
