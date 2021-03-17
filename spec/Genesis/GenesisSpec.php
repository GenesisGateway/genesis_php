<?php

namespace spec\Genesis;

use Genesis\API\Constants\Transaction\Types;
use Genesis\API\Response;
use Genesis\Exceptions\DeprecatedMethod;
use Genesis\Network;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Base\RequestStub;

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

        $this->request()->shouldHaveType('\Genesis\API\Request\NonFinancial\Blacklist');
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

        $this->request()->shouldHaveType('\Genesis\API\Request\Financial\Cards\Sale');
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

        $this->request()->shouldHaveType('\Genesis\API\Request\Financial\Cancel');
    }

    public function it_can_set_request_property()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');

        $this->request()->shouldHaveType('\Genesis\API\Request\NonFinancial\Blacklist');

        $this->request()->setCardNumber('420000');

        $this->request()->getCardNumber()->shouldBe('420000');
    }

    public function it_can_send_request()
    {
        $this->beConstructedWith('NonFinancial\Blacklist');

        $this->request()->setCardNumber('4200000000000000');

        $this->shouldThrow('\Genesis\Exceptions\ErrorNetwork')->during('execute');

        $this->response()->getResponseObject()->shouldBe(null);
    }

    public function it_should_assign_response_to_request_object(Response $response, Network $network, RequestStub $request)
    {
        $this->beAnInstanceOf(\spec\Genesis\API\Stubs\Base\GenesisStub::class);
        $this->beConstructedWith('NonFinancial\Blacklist');

        $this->setResponse($response);
        $this->setNetwork($network);
        $this->setRequest($request);

        $request->setResponse($this->response())->shouldBeCalled();

        $this->execute();
    }

    public function it_fails_on_deprecated_request()
    {
        $this->beConstructedWith('NonFinancial\AVS');

        $this->shouldThrow('\Genesis\Exceptions\DeprecatedMethod')->duringInstantiation();
    }

    public function it_fails_on_deprecated_inpay_request()
    {
        $this->beConstructedWith('Financial\Alternatives\INPay');

        $this->shouldThrow('\Genesis\Exceptions\DeprecatedMethod')->duringInstantiation();
    }

    public function it_fails_on_deprecated_abnideal_request()
    {
        $this->beConstructedWith('Financial\Alternatives\ABNiDEAL');

        $this->shouldThrow('\Genesis\Exceptions\DeprecatedMethod')->duringInstantiation();
    }

    public function it_fails_on_deprecated_abnideal_api_request()
    {
        $this->beConstructedWith('NonFinancial\Retrieve\AbniDealBanks');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_entercash_request()
    {
        $this->beConstructedWith('Financial\OnlineBankingPayments\Entercash');

        $this->shouldThrow('\Genesis\Exceptions\DeprecatedMethod')->duringInstantiation();
    }

    public function it_fails_on_deprecated_banamex_request()
    {
        $this->beConstructedWith('Financial\CashPayments\Banamex');

        $this->shouldThrow('\Genesis\Exceptions\DeprecatedMethod')->duringInstantiation();
    }

    public function it_fails_on_deprecated_citadel_payin_request()
    {
        $this->beConstructedWith('Financial\OnlineBankingPayments\Citadel\Payin');

        $this->shouldThrow('\Genesis\Exceptions\DeprecatedMethod')->duringInstantiation();
    }

    public function it_fails_on_deprecated_citadel_payout_request()
    {
        $this->beConstructedWith('Financial\OnlineBankingPayments\Citadel\Payout');

        $this->shouldThrow('\Genesis\Exceptions\DeprecatedMethod')->duringInstantiation();
    }

    public function it_fails_on_deprecated_pay_by_vouchers_obep_request()
    {
        $this->beConstructedWith('Financial\PayByVouchers\oBeP');

        $this->shouldThrow('\Genesis\Exceptions\DeprecatedMethod')->duringInstantiation();
    }

    public function it_fails_on_deprecated_pay_by_vouchers_sale_request()
    {
        $this->beConstructedWith('Financial\PayByVouchers\Sale');

        $this->shouldThrow('\Genesis\Exceptions\DeprecatedMethod')->duringInstantiation();
    }

    public function it_fails_on_deprecated_astropay_direct_request()
    {
        $this->beConstructedWith('Financial\OnlineBankingPayments\AstropayDirect');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_astropay_card_request()
    {
        $this->beConstructedWith('Financial\Vouchers\AstropayCard');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_emprese_de_energia_request()
    {
        $this->beConstructedWith('Financial\CashPayments\EmpreseDeEnergia');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_carulla_request()
    {
        $this->beConstructedWith('Financial\CashPayments\Carulla');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_surtimax_request()
    {
        $this->beConstructedWith('Financial\CashPayments\Surtimax');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_hipercard_request()
    {
        $this->beConstructedWith('Financial\Cards\Hipercard');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_earthport_request()
    {
        $this->beConstructedWith('Financial\Alternatives\Earthport');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_alipay_request()
    {
        $this->beConstructedWith('Financial\OnlineBankingPayments\Alipay');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_zimpler_request()
    {
        $this->beConstructedWith('Financial\Wallets\Zimpler');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_santander_cash_request()
    {
        $this->beConstructedWith('Financial\CashPayments\SantanderCash');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_qiwi_request()
    {
        $this->beConstructedWith('Financial\Wallets\Qiwi');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_instant_transfer_request()
    {
        $this->beConstructedWith('Financial\OnlineBankingPayments\InstantTransfer');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_deprecated_trustly_withdrawal_request()
    {
        $this->beConstructedWith('Financial\Alternatives\Trustly\Withdrawal');

        $this->shouldThrow(DeprecatedMethod::class)->duringInstantiation();
    }

    public function it_fails_on_non_existing_transaction_request()
    {
        $this->beConstructedWith('Non\Existing\Transaction');

        $this->shouldThrow('\Genesis\Exceptions\InvalidMethod')->duringInstantiation();
    }
}
