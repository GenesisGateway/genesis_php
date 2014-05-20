<?php

namespace spec\Genesis\API\Request\Financial\Recurring;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InitRecurringSale3DSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Recurring\InitRecurringSale3D');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->Build();
        $this->getDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->duringSend();
    }

    function it_should_send_without_issues()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->duringSend();
        $this->getGenesisResponse()->shouldNotBeEmpty();
    }

    function setRequestParameters()
    {
        $this->setTransactionId(mt_rand(PHP_INT_SIZE, PHP_INT_MAX));
        $this->setAmount(mt_rand(1, 10015523));
        $this->setCurrency('USD');
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp('127.0.0.1');
        $this->setCardHolder('Max Musterman');
        $this->setCardNumber('4200000000000000');
        $this->setCvv(sprintf("%03s", mt_rand(1,999)));
        $this->setExpirationMonth(mt_rand(01,12));
        $this->setExpirationYear(mt_rand(2015,2020));
        $this->setCustomerEmail('test@emerchantpay.com');
        $this->setCustomerPhone('+359000');
        $this->setBillingFirstName('Max');
        $this->setBillingLastName('Musterman');
        $this->setBillingAddress1('Muster Str. 12');
        $this->setBillingZipCode('89110');
        $this->setBillingCity('Las Vegas');
        $this->setBillingState('NV');
        $this->setBillingCountry('US');
        $this->setNotificationUrl('https://94.26.28.144/handleGenesis.php');
        $this->setReturnSuccessUrl('https://notify.me');
        $this->setReturnFailureUrl('https://notify.me');
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function($subject) {
                    return empty($subject);
                },
        );
    }
}
