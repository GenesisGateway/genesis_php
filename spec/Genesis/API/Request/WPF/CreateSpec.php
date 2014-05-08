<?php

namespace spec\Genesis\API\Request\WPF;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \Genesis\API as API;

require_once __DIR__ . '/../../../SpecHelper.php';

class CreateSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\WPF\Create');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->Build();
        $this->getDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow('\Genesis\Exceptions\BlankRequiredField')->duringSend();
    }

    function it_should_send_without_issues()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow('\Genesis\Exceptions\BlankRequiredField')->duringSend();
        $this->getGenesisResponse()->shouldNotBeEmpty();
    }

    function setRequestParameters()
    {
        $this->setTransactionId(mt_rand(PHP_INT_SIZE, PHP_INT_MAX));
        $this->setAmount(mt_rand(1, 10015523));
        $this->setCurrency('USD');
        $this->setUsage('40208 Concert Tickets');
        $this->setDescription('Genesis PHP Client Example Request');
        $this->setNotificationUrl('https://94.26.28.144:22303/handleGenesis.php');
        $this->setReturnSuccessUrl('https://94.26.28.144:22303/handleGenesis.php?redir=success');
        $this->setReturnFailureUrl('https://94.26.28.144:22303/handleGenesis.php?redir=failure');
        $this->setReturnCancelUrl('https://94.26.28.144:22303/handleGenesis.php?redir=cancel');
        $this->setCustomerEmail('test@emerchantpay.com');
        $this->setCustomerPhone('+359000');
        $this->setBillingFirstName('Max');
        $this->setBillingLastName('Musterman');
        $this->setBillingAddress1('Muster Str. 12');
        $this->setBillingZipCode('89110');
        $this->setBillingCity('Las Vegas');
        $this->setBillingState('NV');
        $this->setBillingCountry('US');
        $this->addTransactionType('sale');
        $this->addTransactionType('sale3d');
    }

    public function getMatchers()
    {
        return [
            'beEmpty' => function($subject) {
                    return empty($subject);
                },
        ];
    }
}
