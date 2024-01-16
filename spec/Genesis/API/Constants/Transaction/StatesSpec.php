<?php

namespace spec\Genesis\API\Constants\Transaction;

use Genesis\API\Constants\Transaction\States;
use Genesis\Utils\Common;
use PhpSpec\ObjectBehavior;

class StatesSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Constants\Transaction\States');
    }

    public function it_should_have_magic_is_approved()
    {
        $this->beConstructedWith(States::APPROVED);
        $method = $this->buildMethod(States::APPROVED);

        $this->$method()->shouldBe(true);
    }

    public function it_should_have_magic_is_declined()
    {
        $this->beConstructedWith(States::DECLINED);
        $method = $this->buildMethod(States::DECLINED);

        $this->$method()->shouldBe(true);
    }

    public function it_should_have_magic_is_pending()
    {
        $this->beConstructedWith(States::PENDING);

        $this->{$this->buildMethod(States::PENDING)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_pending_async()
    {
        $this->beConstructedWith(States::PENDING_ASYNC);

        $this->{$this->buildMethod(States::PENDING_ASYNC)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_in_progress()
    {
        $this->beConstructedWith(States::IN_PROGRESS);

        $this->{$this->buildMethod(States::IN_PROGRESS)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_refunded()
    {
        $this->beConstructedWith(States::REFUNDED);

        $this->{$this->buildMethod(States::REFUNDED)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_voided()
    {
        $this->beConstructedWith(States::VOIDED);

        $this->{$this->buildMethod(States::VOIDED)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_error()
    {
        $this->beConstructedWith(States::ERROR);

        $this->{$this->buildMethod(States::ERROR)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_unsuccessful()
    {
        $this->beConstructedWith(States::UNSUCCESSFUL);

        $this->{$this->buildMethod(States::UNSUCCESSFUL)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_new()
    {
        $this->beConstructedWith(States::NEW_STATUS);

        $this->{$this->buildMethod(States::NEW_STATUS)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_new_status()
    {
        $this->beConstructedWith(States::NEW_STATUS);

        $this->isNewStatus()->shouldBe(true);
    }

    public function it_should_have_magic_is_user()
    {
        $this->beConstructedWith(States::USER);

        $this->{$this->buildMethod(States::USER)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_timeout()
    {
        $this->beConstructedWith(States::TIMEOUT);

        $this->{$this->buildMethod(States::TIMEOUT)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_chargebacked()
    {
        $this->beConstructedWith(States::CHARGEBACKED);

        $this->{$this->buildMethod(States::CHARGEBACKED)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_chargeback_reversed()
    {
        $this->beConstructedWith(States::CHARGEBACK_REVERSED);

        $this->{$this->buildMethod(States::CHARGEBACK_REVERSED)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_pre_arbitrated()
    {
        $this->beConstructedWith(States::PRE_ARBITRATED);

        $this->{$this->buildMethod(States::PRE_ARBITRATED)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_enabled()
    {
        $this->beConstructedWith(States::ENABLED);

        $this->{$this->buildMethod(States::ENABLED)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_disabled()
    {
        $this->beConstructedWith(States::DISABLED);

        $this->{$this->buildMethod(States::DISABLED)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_success()
    {
        $this->beConstructedWith(States::SUCCESS);

        $this->{$this->buildMethod(States::SUCCESS)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_submitted()
    {
        $this->beConstructedWith(States::SUBMITTED);

        $this->{$this->buildMethod(States::SUBMITTED)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_pending_hold()
    {
        $this->beConstructedWith(States::PENDING_HOLD);

        $this->{$this->buildMethod(States::PENDING_HOLD)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_second_chargebacked()
    {
        $this->beConstructedWith(States::SECOND_CHARGEBACKED);

        $this->{$this->buildMethod(States::SECOND_CHARGEBACKED)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_represented()
    {
        $this->beConstructedWith(States::REPRESENTED);

        $this->{$this->buildMethod(States::REPRESENTED)}()->shouldBe(true);
    }

    public function it_should_have_magic_is_representment_reversed()
    {
        $this->beConstructedWith(States::REPRESENTMENT_REVERSED);

        $this->{$this->buildMethod(States::REPRESENTMENT_REVERSED)}()->shouldBe(true);
    }

    public function it_should_compare_properly_statuses()
    {
        $this->beConstructedWith(States::NEW_STATUS);

        $this->isApproved()->shouldBe(false);
    }

    private function buildMethod($status)
    {
        return 'is' . Common::snakeCaseToCamelCase($status);
    }
}
