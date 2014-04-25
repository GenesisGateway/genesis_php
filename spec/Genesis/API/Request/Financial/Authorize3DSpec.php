<?php

namespace spec\Genesis\API\Request\Financial;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class Authorize3DSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Request\Financial\Authorize3D');
    }

    function it_can_build_stucture()
    {
        $this->setRequestParameters();
        $this->generateXML();
        $this->getXMLDocument()->shouldNotBeEmpty();
    }

    function it_should_fail_when_no_parameters()
    {
        $this->shouldThrow()->duringSubmitRequest();
    }

    function it_should_send_without_issues()
    {
        $this->setRequestParameters();
        $this->shouldNotThrow()->duringSubmitRequest();
        $this->getGenesisResponse()->shouldNotBeEmpty();
    }

    function setRequestParameters()
    {
        $this->setTransactionId(mt_rand(PHP_INT_SIZE, PHP_INT_MAX));
        $this->setAmount(mt_rand(40, 16244600));
        $this->setCurrency('USD');
        $this->setUsage('Genesis PHP Client Automated testing');
        $this->setRemoteIp('127.0.0.1');
        $this->setCardHolder('Max Musterman');
        $this->setCardNumber('4200000000000000');
        $this->setCvv('000');
        $this->setExpirationMonth('01');
        $this->setExpirationYear('2014');
        $this->setCustomerEmail('test@emerchantpay.com');
        $this->setCustomerPhone('+359000');
        $this->setBillingFirstName('Max');
        $this->setBillingLastName('Musterman');
        $this->setBillingAddress1('Muster Str. 12');
        $this->setBillingZipCode('89110');
        $this->setBillingCity('Las Vegas');
        $this->setBillingState('NV');
        $this->setBillingCountry('US');
        $this->setNotificationUrl('https://notify.me');
        $this->setReturnSuccessUrl('https://notify.me');
        $this->setReturnFailureUrl('https://notify.me');
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
