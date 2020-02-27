<?php

namespace spec\Genesis\API;

use Genesis\Config;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotificationSpec extends ObjectBehavior
{
    private $sample = array(
        'api'   => array(
            'unique_id'     => '',
            'signature'     => '',
            'status'        => 'approved',
        ),
        'wpf'   => array(
            'wpf_unique_id' => '',
            'signature'     => '',
            'status'        => 'approved',
        )
    );

    public function __construct()
    {
        for ($i=0; $i < mt_rand(32, 48); $i++) {
            $this->sample['api']['unique_id'] .= chr(mt_rand(97, 122));
        }

        $this->sample['api']['signature'] = hash(
            'sha1',
            $this->sample['api']['unique_id'] . \Genesis\Config::getPassword()
        );

        for ($i=0; $i < mt_rand(32, 48); $i++) {
            $this->sample['wpf']['wpf_unique_id'] .= chr(mt_rand(97, 122));
        }

        $this->sample['wpf']['signature'] = hash(
            'sha1',
            $this->sample['wpf']['wpf_unique_id'] . \Genesis\Config::getPassword()
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\API\Notification');
    }

    public function it_can_verify_api_notification()
    {
        $this->shouldNotThrow()->during('parseNotification', array($this->sample['api']));

        $this->isAPINotification()->shouldBe(true);
        $this->isWPFNotification()->shouldBe(false);

        $this->isAuthentic()->shouldBe(true);
    }

    public function it_can_verify_wpf_notification()
    {
        $this->shouldNotThrow()->during('parseNotification', array($this->sample['wpf']));

        $this->isAPINotification()->shouldBe(false);
        $this->isWPFNotification()->shouldBe(true);

        $this->isAuthentic()->shouldBe(true);
    }

    public function it_should_fail_api_auth_verification()
    {
        $sample = $this->sample['api'];
        $sample['signature'] = 'THIS-HASH-IS-INVALID';

        $this->shouldThrow()->during('parseNotification', array($sample));

        $this->isAPINotification()->shouldBe(true);
        $this->isWPFNotification()->shouldBe(false);

        $this->isAuthentic()->shouldBe(false);
    }

    public function it_should_fail_wpf_auth_verification()
    {
        $sample = $this->sample['wpf'];
        $sample['signature'] = 'THIS-HASH-IS-INVALID';

        $this->shouldThrow()->during('parseNotification', array($sample));

        $this->isAPINotification()->shouldBe(false);
        $this->isWPFNotification()->shouldBe(true);

        $this->isAuthentic()->shouldBe(false);
    }

    public function it_can_generate_api_xml_response()
    {
        $this->shouldNotThrow()->during('parseNotification', array($this->sample['api']));
        $this->generateResponse()->shouldNotBeEmpty();
    }

    public function it_can_generate_wpf_xml_response()
    {
        $this->shouldNotThrow()->during('parseNotification', array($this->sample['wpf']));
        $this->generateResponse()->shouldNotBeEmpty();
    }

    public function it_can_render_api_response()
    {
        $this->shouldNotThrow()->during('parseNotification', array($this->sample['api']));
        $this->generateResponse()->shouldContain('unique_id');
    }

    public function it_can_render_wpf_response()
    {
        $this->shouldNotThrow()->during('parseNotification', array($this->sample['wpf']));
        $this->generateResponse()->shouldContain('wpf_unique_id');
    }

    public function it_should_fail_without_api_id()
    {
        $api = $this->sample['api'];
        unset($api['unique_id']);

        $this->shouldThrow()->during('parseNotification', array($api));
    }

    public function it_should_fail_without_wpf_id()
    {
        $wpf = $this->sample['wpf'];
        unset($wpf['wpf_unique_id']);

        $this->shouldThrow()->during('parseNotification', array($wpf));
    }

    public function it_should_fail_without_api_signature()
    {
        $api = $this->sample['api'];
        unset($api['signature']);

        $this->shouldThrow()->during('parseNotification', array($api));
    }

    public function it_should_fail_without_wpf_signature()
    {
        $wpf = $this->sample['wpf'];
        unset($wpf['signature']);

        $this->shouldThrow()->during('parseNotification', array($wpf));
    }

    public function it_should_parse_api_notification()
    {
        $this->shouldNotThrow()->during('parseNotification', array($this->sample['api']));
        $this->getNotificationObject()->shouldNotBeEmpty();
    }

    public function it_should_parse_and_clean_api_notification()
    {
        $invalid_data = array(
            ' sig%33'   => ' ' . $this->sample['api']['signature'] . '%33',
            'sig%55 '   => '%75' . $this->sample['api']['signature'] . ' ',
            ' $alpha '  => ' '
        );

        $this->shouldNotThrow()->during('parseNotification', array(array_merge($this->sample['api'], $invalid_data)));
        $this->getNotificationObject()->sig3->shouldBe($this->sample['api']['signature'] . '3');
        $this->getNotificationObject()->sigU->shouldBe('u' . $this->sample['api']['signature']);
        $this->getNotificationObject()->{'$alpha'}->shouldBe('');
    }

    public function it_should_parse_wpf_notification()
    {
        $this->shouldNotThrow()->during('parseNotification', array($this->sample['wpf']));
        $this->getNotificationObject()->shouldNotBeEmpty();
    }

    public function it_should_parse_and_clean_wpf_notification()
    {
        $invalid_data = array(
            ' sig%33'   => ' ' . $this->sample['wpf']['signature'] . '%33',
            'sig%55 '   => '%75' . $this->sample['wpf']['signature'] . ' ',
            ' $alpha '  => ' '
        );

        $this->shouldNotThrow()->during('parseNotification', array(array_merge($this->sample['wpf'], $invalid_data)));
        $this->getNotificationObject()->sig3->shouldBe($this->sample['wpf']['signature'] . '3');
        $this->getNotificationObject()->sigU->shouldBe('u' . $this->sample['wpf']['signature']);
        $this->getNotificationObject()->{'$alpha'}->shouldBe('');
    }

    public function it_can_render_api_response_correctly()
    {
        $this->shouldNotThrow()->during('parseNotification', array($this->sample['api']));

        ob_start();

        echo 'Non empty Buffer';

        $this->shouldNotThrow()->during('renderResponse');

        $this->generateResponse()->shouldBe(ob_get_clean());
    }

    public function it_can_render_wpf_response_correctly()
    {
        $this->shouldNotThrow()->during('parseNotification', array($this->sample['wpf']));

        ob_start();

        echo 'Non empty Buffer';

        $this->shouldNotThrow()->during('renderResponse');

        $this->generateResponse()->shouldBe(ob_get_clean());
    }

    public function getMatchers()
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
            'contain' => function ($subject, $arg) {
                return (stripos($subject, $arg) !== false);
            },
        );
    }
}
