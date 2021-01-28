<?php

namespace spec\Genesis\API\Request\Financial\Cards\Threeds\V2;

use Genesis\API\Constants\DateTimeFormat;
use Genesis\API\Constants\Endpoints;
use Genesis\API\Constants\Environments;
use Genesis\API\Request;
use Genesis\API\Request\Financial\Cards\Threeds\V2\MethodContinue;
use Genesis\Builder;
use Genesis\Config;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use Genesis\Genesis;
use Genesis\Utils\Threeds\V2 as ThreedsV2Utils;
use PhpSpec\ObjectBehavior;
use spec\fixtures\API\Stubs\Parser\ParserStub;
use spec\SharedExamples\Faker;
use spec\SharedExamples\Genesis\API\Request\RequestExamples;

class MethodContinueSpec extends ObjectBehavior
{
    use RequestExamples;

    public function it_is_initializable()
    {
        $this->shouldHaveType(MethodContinue::class);
    }

    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'amount'
        ]);
    }

    public function it_should_fail_with_missing_required_timestamp_param()
    {
        $faker = $this->getFaker();

        $this->setTransactionUniqueId($faker->uuid);
        $this->setAmount(1000);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_without_uniqueId_or_continue_url()
    {
        $faker = $this->getFaker();

        $this->setTransactionTimestamp($faker->time(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU));
        $this->setAmount(1000);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_fail_when_continue_url_set_without_uniqueID()
    {
        $faker = $this->getFaker();

        $this->setUrl('https://example.com/' . $faker->uuid);
        $this->setAmount(1000);
        $this->setTransactionTimestamp($faker->time(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU));

        $this->shouldNotThrow()->during('getDocument');
    }

    public function it_should_extract_uniqueId_from_continue_url()
    {
        $faker = $this->getFaker();
        $uuid  = $faker->uuid;

        $this->setUrl('https://example.com/' . $uuid);

        $this->getTransactionUniqueId()->shouldBe($uuid);
    }

    public function it_should_fail_with_invalid_timestamp_format()
    {
        $this->shouldThrow(InvalidArgument::class)->during('setTransactionTimestamp', ['fake']);
    }

    public function it_should_convert_amount_to_exponent()
    {
        $uuid      = Faker::getInstance()->uuid;
        $timestamp = Faker::getInstance()->time(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU);

        $this->setAmount('10.00');
        $this->setCurrency('EUR');
        $this->setTransactionTimestamp($timestamp);
        $this->setTransactionUniqueId($uuid);

        $signature = ThreedsV2Utils::generateSignature(
            $uuid,
            1000,
            $timestamp,
            Config::getPassword()
        );

        $this->getDocument()->shouldContain('signature=' . $signature);
    }

    public function it_should_set_correct_amount()
    {
        $this->setAmount('10.00');
        $this->getAmount()->shouldBe('10.00');

        $this->setAmount(1000);
        $this->getAmount()->shouldBe(1000);
    }

    public function it_should_have_correct_signature()
    {
        $this->setRequestParameters();
        $this->setSignature('user_signature');

        $this->getSignature()->shouldBe('user_signature');
    }

    public function it_should_generate_correct_signature_value()
    {
        $faker = $this->getFaker();


        $password  = $faker->password;
        $uniqueId  = $faker->uuid;
        $amount    = '10.00';
        $currency  = 'EUR';
        $timestamp = $faker->time(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU);

        Config::setPassword($password);
        $this->setTransactionUniqueId($uniqueId);
        $this->setAmount($amount);
        $this->setCurrency($currency);
        $this->setTransactionTimestamp($timestamp);

        $hash = hash(
            "sha512",
            $uniqueId . 1000 . $timestamp . $password,
            false
        );

        $this->getSignature()->shouldBe($hash);
    }

    public function it_should_not_fail_with_correct_url()
    {
        $this->shouldNotThrow()->during('setUrl', [Faker::getInstance()->url]);
    }

    public function it_should_fail_with_invalid_url()
    {
        $this->shouldThrow(InvalidArgument::class)->during(
            'setUrl', ['invalid_url']
        );
    }

    public function it_should_initialize_correct_endpoint_url()
    {
        Config::setEnvironment(Environments::STAGING);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->getApiConfig('url')->shouldBe(
            'https://staging.gate.emerchantpay.net:443/threeds/threeds_method/:unique_id'
        );
    }

    public function it_should_set_correct_endpoint_url_with_unique_id()
    {
        Config::setEnvironment(Environments::STAGING);
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setTransactionUniqueId('transaction_unique_id');
        $this->setAmount(1000);
        $this->setTransactionTimestamp(Faker::getInstance()->time(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU));

        $this->getDocument();

        $this->getApiConfig('url')->shouldBe(
            'https://staging.gate.emerchantpay.net:443/threeds/threeds_method/transaction_unique_id'
        );
    }

    public function it_should_have_correct_config()
    {
        $this->config->offsetGet('format')->shouldBe(Builder::FORM);
        $this->config->offsetGet('type')->shouldBe(Request::METHOD_PUT);
    }

    public function it_should_not_modify_method_callback_url_endpoint()
    {
        $this->setUrl('https://example.com/unique_id');
        $this->setAmount(1000);
        $this->setTransactionTimestamp(Faker::getInstance()->time(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU));

        $this->getDocument();

        $this->getApiConfig('url')->shouldBe('https://example.com/unique_id');
    }

    protected function setRequestParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionUniqueId($faker->uuid);
        $this->setTransactionTimestamp($faker->time(DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU));
        $this->setAmount(1000);
    }

    public function it_should_fail_load_with_empty_response()
    {
        $this->shouldThrow(ErrorParameter::class)->during(
            'buildFromResponseObject',
            [(new \stdClass())]
        );
    }

    public function it_should_load_correct_object_from_response($response)
    {
        $this->prepareResponseMock($response);
        Config::setPassword('password_hash');

        $genesis = $this::buildFromResponseObject($this->response->getResponseObject())->shouldHaveType(
            Genesis::class
        );

        $this->setTransactionUniqueId('de7e722035f04839bc30676cf3c4eae9');
        $this->setTransactionTimestamp('2020-10-07T16:07:33Z');
        $this->setAmount('10.00');
        $this->setCurrency('EUR');

        $this->getTransactionUniqueId()->shouldBe($genesis->request()->getTransactionUniqueId());
        $this->getTransactionTimestamp()->shouldBe($genesis->request()->getTransactionTimestamp());
        $this->getAmount()->shouldBe($genesis->request()->getAmount());
        $this->getSignature()->shouldBe($genesis->request()->getSignature());
    }

    protected function prepareResponseMock($response)
    {
        $parser = new ParserStub('Financial\Threeds\V2');

        $response->beADoubleOf('Genesis\API\Response');
        $response->getResponseObject()->willReturn(
            $parser->Transaction('xml', 'response')->getParsedDocument()
        );

        $this->response = $response;
    }
}

