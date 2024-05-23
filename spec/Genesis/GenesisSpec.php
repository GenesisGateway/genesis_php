<?php

namespace spec\Genesis;

use Genesis\Api\Constants\Transaction\Types;
use Genesis\Api\Response;
use Genesis\Exceptions\DeprecatedMethod;
use Genesis\Network;
use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Base\GenesisStub;
use spec\Genesis\Api\Stubs\Base\RequestStub;

class GenesisSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');
        $this->shouldHaveType('Genesis\Genesis');
    }

    public function it_can_load_request()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');

        $this->request()->shouldHaveType('\Genesis\Api\Request\NonFinancial\Blacklist');
    }

    public function it_can_load_financial_request_from_factory()
    {
        $params = [
            'card_number' => '420000',
            'card_holder' => 'Card Holder'
        ];

        $this->beConstructedThrough(
            'financialFactory',
            [
                Types::SALE,
                $params
            ]
        );
        $this->shouldHaveType('\Genesis\Genesis');

        $this->request()->shouldHaveType('\Genesis\Api\Request\Financial\Cards\Sale');
        $this->request()->getCardNumber()->shouldBe('420000');
        $this->request()->getCardHolder()->shouldBe('Card Holder');
    }

    public function it_should_fail_loading_financial_request_from_factory_with_wrong_type()
    {
        $this->beConstructedThrough(
            'financialFactory',
            [
                'wrong_type'
            ]
        );

        $this->shouldThrow('\Genesis\Exceptions\InvalidArgument')->duringInstantiation();
    }

    public function it_should_fail_loading_financial_request_from_factory_with_wrong_params()
    {
        $params = [
            'wrong' => 'parameter'
        ];

        $this->beConstructedThrough(
            'financialFactory',
            [
                Types::SALE,
                $params
            ]
        );

        $this->shouldThrow('\Genesis\Exceptions\InvalidMethod')->duringInstantiation();
    }

    public function it_can_load_deprecated_void_request()
    {
        $this->beConstructedWith('Financial\Void');

        $this->request()->shouldHaveType('\Genesis\Api\Request\Financial\Cancel');
    }

    public function it_can_set_request_property()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');

        $this->request()->shouldHaveType('\Genesis\Api\Request\NonFinancial\Blacklist');

        $this->request()->setCardNumber('420000');

        $this->request()->getCardNumber()->shouldBe('420000');
    }

    public function it_can_send_request(Response $response, Network $network, RequestStub $request)
    {
        $this->beAnInstanceOf(GenesisStub::class);
        $this->beConstructedWith('NonFinancial\Blacklist');

        $this->request()->setCardNumber('4200000000000000');

        $this->setResponse($response);
        $this->setNetwork($network);
        $this->setRequest($request);

        $this->mockExecute();

        $this->shouldNotThrow()->during('execute');

        $this->response()->getResponseObject()->shouldBe(null);
    }

    public function it_should_assign_response_to_request_object(Response $response, Network $network, RequestStub $request)
    {
        $this->beAnInstanceOf(\spec\Genesis\Api\Stubs\Base\GenesisStub::class);
        $this->beConstructedWith('NonFinancial\Blacklist');

        $this->setResponse($response);
        $this->setNetwork($network);
        $this->setRequest($request);

        $request->setResponse($this->response())->shouldBeCalled();

        $this->execute();
    }

    public function it_fails_on_non_existing_transaction_request()
    {
        $this->beConstructedWith('Non\Existing\Transaction');

        $this->shouldThrow('\Genesis\Exceptions\InvalidMethod')->duringInstantiation();
    }
}
