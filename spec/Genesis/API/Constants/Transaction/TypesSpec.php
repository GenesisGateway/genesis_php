<?php

namespace spec\Genesis\API\Constants\Transaction;

use Genesis\API\Constants\Transaction\Types;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TypesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\Transaction\Types');
    }

    public function it_can_validate_transaction_types()
    {
        $this->isValidTransactionType(Types::SALE)->shouldReturn(true);
        $this->isValidTransactionType('non-existing-trx-type')->shouldReturn(false);
    }

    public function it_can_detect_supported_wpf_trx_types()
    {
        $this->isValidWPFTransactionType(Types::EZEEWALLET)->shouldReturn(true);
        $this->isValidWPFTransactionType(Types::IDEBIT_PAYIN)->shouldReturn(true);
    }

    public function it_can_detect_not_supported_wpf_trx_types()
    {
        $this->isValidWPFTransactionType(Types::EARTHPORT)->shouldReturn(false);
    }

    public function it_can_validate_pay_by_voucher_transaction_types()
    {
        $this->isPayByVoucher(Types::PAYBYVOUCHER_YEEPAY)->shouldReturn(true);
        $this->isPayByVoucher(Types::PAYBYVOUCHER_SALE)->shouldReturn(true);
        $this->isPayByVoucher(Types::EARTHPORT)->shouldReturn(false);
    }

    public function it_can_detect_3d_transaction_types()
    {
        $this->is3D(Types::SALE_3D)->shouldReturn(true);
        $this->is3D(Types::SALE)->shouldReturn(false);
        $this->is3D('test_3d_fake')->shouldReturn(false);
    }

    public function it_can_validate_split_payments_transaction_types()
    {
        $this->isValidSplitPaymentTrxType(Types::INTERSOLVE)->shouldReturn(true);
        $this->isValidSplitPaymentTrxType(Types::SALE)->shouldReturn(true);
        $this->isValidSplitPaymentTrxType(Types::AUTHORIZE)->shouldReturn(false);
    }

    public function it_can_get_custom_required_parameters()
    {
        $this->getCustomRequiredParameters(Types::PPRO)->shouldNotBe(false);
        $this->getCustomRequiredParameters(Types::PAYBYVOUCHER_SALE)->shouldNotBe(false);
        $this->getCustomRequiredParameters(Types::PAYBYVOUCHER_YEEPAY)->shouldNotBe(false);
        $this->getCustomRequiredParameters(Types::INSTA_DEBIT_PAYIN)->shouldNotBe(false);
        $this->getCustomRequiredParameters(Types::IDEBIT_PAYIN)->shouldNotBe(false);
        $this->getCustomRequiredParameters(Types::CITADEL_PAYIN)->shouldNotBe(false);
        $this->getCustomRequiredParameters(Types::KLARNA_AUTHORIZE)->shouldNotBe(false);
    }

    public function it_should_return_array_with_all_transaction_types()
    {
        $this->getAll()->shouldBeArray();
    }

    public function it_should_return_non_empty_array_with_all_transaction_types()
    {
        $this->getAll()->shouldNotBe([]);
    }

    public function it_should_return_array_with_deprecated_transaction_types()
    {
        $this->getDeprecatedRequests()->shouldBeArray();
    }

    public function it_should_be_true_for_voidable_types()
    {
        $typesObject = $this->getWrappedObject();
        $voidableTypes = [
            $typesObject::APPLE_PAY,
            $typesObject::AUTHORIZE,
            $typesObject::AUTHORIZE_3D,
            $typesObject::CAPTURE,
            $typesObject::FASHIONCHEQUE,
            $typesObject::GOOGLE_PAY,
            $typesObject::INTERSOLVE,
            $typesObject::PAY_PAL,
            $typesObject::REFUND,
            $typesObject::SALE,
            $typesObject::SALE_3D,
            $typesObject::TCS,
            $typesObject::TRUSTLY_SALE
        ];

        foreach ($voidableTypes as $type) {
            $this::canVoid($type)->shouldBe(true);
        }
    }

    public function it_should_be_false_for_non_voidable_types()
    {
        $typesObject = $this->getWrappedObject();

        $this::canVoid($typesObject::BALOTO)->shouldBe(false);
    }

    public function it_should_be_true_for_refundable_types()
    {
        $typesObject = $this->getWrappedObject();
        $refundableTypes = [
            $typesObject::APPLE_PAY,
            $typesObject::BALOTO,
            $typesObject::BANCOMER,
            $typesObject::BANCONTACT,
            $typesObject::BANCO_DE_OCCIDENTE,
            $typesObject::BANCO_DO_BRASIL,
            $typesObject::BITPAY_SALE,
            $typesObject::BOLETO,
            $typesObject::BRADESCO,
            $typesObject::CAPTURE,
            $typesObject::CASHU,
            $typesObject::DAVIVIENDA,
            $typesObject::EFECTY,
            $typesObject::EPS,
            $typesObject::FASHIONCHEQUE,
            $typesObject::GIROPAY,
            $typesObject::GOOGLE_PAY,
            $typesObject::IDEAL,
            $typesObject::IDEBIT_PAYIN,
            $typesObject::INIT_RECURRING_SALE,
            $typesObject::INIT_RECURRING_SALE_3D,
            $typesObject::ITAU,
            $typesObject::KLARNA_CAPTURE,
            $typesObject::MY_BANK,
            $typesObject::MY_BANK,
            $typesObject::NEOSURF,
            $typesObject::OXXO,
            $typesObject::P24,
            $typesObject::PAGO_FACIL,
            $typesObject::PARTIAL_REVERSAL,
            $typesObject::PAY_PAL,
            $typesObject::PAYU,
            $typesObject::PPRO,
            $typesObject::PSE,
            $typesObject::POST_FINANCE,
            $typesObject::RAPI_PAGO,
            $typesObject::RECURRING_SALE,
            $typesObject::REDPAGOS,
            $typesObject::SAFETYPAY,
            $typesObject::SALE,
            $typesObject::SALE_3D,
            $typesObject::SANTANDER,
            $typesObject::SDD_INIT_RECURRING_SALE,
            $typesObject::SDD_RECURRING_SALE,
            $typesObject::SDD_SALE,
            $typesObject::SOFORT,
            $typesObject::TRUSTLY_SALE,
            $typesObject::UPI,
            $typesObject::WEBPAY,
            $typesObject::WECHAT,
            $typesObject::ZIMPLER
        ];

        foreach ($refundableTypes as $type) {
            $this::canRefund($type)->shouldBe(true);
        }
    }

    public function it_should_be_false_for_non_refundable_types()
    {
        $typesObject = $this->getWrappedObject();

        $this::canRefund($typesObject::CENCOSUD)->shouldBe(false);
    }

    public function it_should_be_true_for_capturable_types()
    {
        $typesObject = $this->getWrappedObject();
        $capturableTypes = [
            $typesObject::APPLE_PAY,
            $typesObject::AUTHORIZE,
            $typesObject::AUTHORIZE_3D,
            $typesObject::GOOGLE_PAY,
            $typesObject::KLARNA_AUTHORIZE,
            $typesObject::PAY_PAL
        ];

        foreach ($capturableTypes as $type) {
            $this::canCapture($type)->shouldBe(true);
        }
    }

    public function it_should_be_false_for_non_capturable_types()
    {
        $typesObject = $this->getWrappedObject();

        $this::canCapture($typesObject::CENCOSUD)->shouldBe(false);
    }
}
