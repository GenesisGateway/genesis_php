<?php

namespace spec\Genesis\Api\Request\NonFinancial\TransactionApi;

use DateTime;
use Genesis\Api\Request\NonFinancial\TransactionApi\CardExpiryDateUpdate;
use Genesis\Exceptions\ErrorParameter;
use Genesis\Exceptions\InvalidArgument;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;

class CardExpiryDateUpdateSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType(CardExpiryDateUpdate::class);
    }

    public function it_can_build_structure()
    {
        $this->setDefaultParameters();
        $this->getDocument()->shouldBeString();
    }

    public function it_should_fail_with_date_in_the_past()
    {
        $this->setDefaultParameters();
        $this->setExpirationMonth(
            Faker::getInstance()->dateTimeBetween('-2 month', '-1 month')->format('m')
        );
        $this->setExpirationYear(
            Faker::getInstance()->dateTimeBetween('-2 year', '-1 year')->format('y')
        );

        $this->shouldThrow(InvalidArgument::class)->during('getDocument');
    }

    public function it_should_not_fail_with_correct_month()
    {
        $monthObject = Faker::getInstance()->dateTime();

        $this
            ->shouldNotThrow(InvalidArgument::class)
            ->during('setExpirationMonth', [$monthObject->format('m')]);

        $this
            ->shouldNotThrow(InvalidArgument::class)
            ->during('setExpirationMonth', [$monthObject->format('n')]);
    }

    public function it_should_not_fail_with_correct_year()
    {
        $yearObject = Faker::getInstance()->dateTime();

        $this
            ->shouldNotThrow(InvalidArgument::class)
            ->during('setExpirationYear', [$yearObject->format('Y')]);

        $this
            ->shouldNotThrow(InvalidArgument::class)
            ->during('setExpirationYear', [$yearObject->format('y')]);
    }

    public function it_should_fail_during_parsing_with_invalid_month()
    {
        $this
            ->shouldThrow(InvalidArgument::class)
            ->during('setExpirationMonth', ['month']);
    }

    public function it_should_fail_during_parsing_with_invalid_year()
    {
        $this
            ->shouldThrow(InvalidArgument::class)
            ->during('setExpirationYear', ['year']);
    }

    public function it_should_return_correct_month()
    {
        $this->setExpirationMonth('01');
        $this->getExpirationMonth()->shouldBe('01');

        $this->setExpirationMonth('1');
        $this->getExpirationMonth()->shouldBe('01');
    }

    public function it_should_return_correct_year()
    {
        $this->setExpirationYear('20');
        $this->getExpirationYear()->shouldBe('2020');

        $this->setExpirationYear('2020');
        $this->getExpirationYear()->shouldBe('2020');
    }

    public function it_should_fail_with_missing_required_parameter_month()
    {
        $this->setExpirationYear((new DateTime())->format('Y'));
        $this->setTransactionUniqueId(Faker::getInstance()->uuid);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_missing_required_parameter_year()
    {
        $this->setExpirationMonth((new DateTime())->format('n'));
        $this->setTransactionUniqueId(Faker::getInstance()->uuid);

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_fail_with_missing_required_parameter_transaction_id()
    {
        $this->setExpirationYear((new DateTime())->format('Y'));
        $this->setExpirationMonth((new DateTime())->format('n'));

        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_return_correct_structure()
    {
        $this->setDefaultParameters();

        $nodes = [
            'update_card_expiration_request',
            'expiration_month',
            'expiration_year'
        ];

        foreach ($nodes as $node) {
            $this->getDocument()->shouldContain($node);
        }
    }

    public function it_should_build_correct_url()
    {
        $this->setTransactionUniqueId('id-123456');

        $this->getApiConfig('url')->shouldContain('/id-123456');
    }

    private function setDefaultParameters()
    {
        $this->setExpirationMonth((new DateTime())->format('m'));
        $this->setExpirationYear((new DateTime())->format('y'));
        $this->setTransactionUniqueId(Faker::getInstance()->uuid);
    }
}
