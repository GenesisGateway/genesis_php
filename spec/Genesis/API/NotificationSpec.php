<?php

namespace spec\Genesis\API;

use Genesis\Configuration;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotificationSpec extends ObjectBehavior
{
    private $data = array(
        'unique_id' => 'notification_spec_test',
        'signature' => 'empty_hash',
        'status'    => 'approved',
    );

    function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Notification');
    }

    function it_can_verify_standard_notification()
    {
        $this->data['signature'] = hash('sha1', $this->data['unique_id'] . Configuration::getPassword());

        $this->shouldNotThrow()->duringParseNotification($this->data);
        $this->verifyNotificationAuthenticity()->shouldBeTrue();
    }

    function it_can_verify_wpf_notification()
    {
        $this->data['wpf_unique_id'] = $this->data['unique_id'];
        $this->data['signature'] = hash('sha512', $this->data['unique_id'] . Configuration::getPassword());

        $this->shouldNotThrow()->duringParseNotification($this->data);
        $this->verifyNotificationAuthenticity()->shouldBeTrue();
    }

    function it_can_generate_xml_response()
    {
        $this->parseNotification($this->data);
        $this->generateNotificationResponse()->shouldNotBeEmpty();
    }

    function it_should_fail_without_status()
    {
        unset($this->data['status']);

        $this->shouldThrow()->duringParseNotification($this->data);
        $this->verifyNotificationAuthenticity()->shouldBeFalse();
    }

    function it_should_fail_without_id()
    {
        unset($this->data['unique_id']);

        $this->shouldThrow()->duringParseNotification($this->data);
    }

    function it_should_fail_without_signature()
    {
        unset($this->data['signature']);

        $this->shouldThrow()->duringParseNotification($this->data);
    }

    function getMatchers()
    {
        return [
            'beEmpty' => function($subject) {
                    return empty($subject);
            },
            'beFalse' => function($subject) {
                    return (!$subject) ? true : false;
            },
            'beTrue' => function($subject) {
                    return ($subject) ? true : false;
            },
        ];
    }
}
