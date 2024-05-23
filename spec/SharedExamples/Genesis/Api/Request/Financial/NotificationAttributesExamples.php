<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use spec\SharedExamples\Faker;

trait NotificationAttributesExamples
{
    public function it_should_accept_valid_url_for_notification_url()
    {
        $this->shouldNotThrow()->during('setNotificationUrl',
            [Faker::getInstance()->url()]
        );
    }

    public function it_should_return_string_for_return_notification_url()
    {
        $this->setNotificationUrl(Faker::getInstance()->url())
            ->getNotificationUrl()->shouldBeString();
    }

    public function it_should_not_fail_with_null_value_for_return_notification_url()
    {
        $this->shouldNotThrow()->during('setNotificationUrl', [null]);
    }

    public function it_should_contain_notification_url()
    {
        $url = Faker::getInstance()->url;
        $this->setRequestParameters();
        $this->setNotificationUrl($url);

        $this->getDocument()->shouldContain("<notification_url>$url</notification_url>");
    }
}
