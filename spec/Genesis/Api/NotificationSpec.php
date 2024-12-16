<?php

namespace spec\Genesis\Api;

use Genesis\Config;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Faker;

class NotificationSpec extends ObjectBehavior
{
    private $password;
    private $terminal_token;
    private $unique_id;
    private $wpf_unique_id;

    private $sample = array(
        'api'   => array(
            'unique_id'      => '',
            'signature'      => '',
            'status'         => 'approved',
            'terminal_token' => ''
        ),
        'wpf'   => array(
            'wpf_unique_id'                      => '',
            'signature'                          => '',
            'status'                             => 'approved',
            'payment_transaction_terminal_token' => ''
        )
    );

    public function __construct()
    {
        $this->password       = Faker::getInstance()->uuid;
        $this->terminal_token = Faker::getInstance()->uuid;

        Config::setPassword($this->password);

        for ($i=0; $i < mt_rand(32, 48); $i++) {
            $this->sample['api']['unique_id'] .= chr(mt_rand(97, 122));
        }

        $this->unique_id                  = $this->sample['api']['unique_id'];
        $this->sample['api']['signature'] = hash('sha1', $this->unique_id . Config::getPassword());

        for ($i=0; $i < mt_rand(32, 48); $i++) {
            $this->sample['wpf']['wpf_unique_id'] .= chr(mt_rand(97, 122));
        }

        $this->wpf_unique_id              = $this->sample['wpf']['wpf_unique_id'];
        $this->sample['wpf']['signature'] = hash('sha1', $this->wpf_unique_id . Config::getPassword());

        $this->sample['api']['terminal_token']                     = $this->terminal_token;
        $this->sample['wpf']['payment_transaction_terminal_token'] = $this->terminal_token;
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Api\Notification');
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

    public function it_can_verify_api_sha1_notification()
    {
        $this->sample['api']['signature'] = hash('sha1', "{$this->sample['api']['unique_id']}$this->password");

        $this->shouldNotThrow()->during('parseNotification', array($this->sample['api']));

        $this->isAuthentic()->shouldBe(true);
    }

    public function it_can_verify_api_sha256_notification()
    {
        $this->sample['api']['signature'] = hash('sha256', "{$this->sample['api']['unique_id']}$this->password");

        $this->shouldNotThrow()->during('parseNotification', array($this->sample['api']));

        $this->isAuthentic()->shouldBe(true);
    }

    public function it_can_verify_api_sha512_notification()
    {
        $this->sample['api']['signature'] = hash('sha512', "{$this->sample['api']['unique_id']}$this->password");

        $this->shouldNotThrow()->during('parseNotification', array($this->sample['api']));

        $this->isAuthentic()->shouldBe(true);
    }

    public function it_can_verify_wpf_sha1_notification()
    {
        $this->sample['wpf']['signature'] = hash('sha1', "{$this->sample['wpf']['wpf_unique_id']}$this->password");

        $this->shouldNotThrow()->during('parseNotification', array($this->sample['wpf']));

        $this->isAuthentic()->shouldBe(true);
    }

    public function it_can_verify_wpf_sha256_notification()
    {
        $this->sample['wpf']['signature'] = hash('sha256', "{$this->sample['wpf']['wpf_unique_id']}$this->password");

        $this->shouldNotThrow()->during('parseNotification', array($this->sample['wpf']));

        $this->isAuthentic()->shouldBe(true);
    }

    public function it_can_verify_wpf_sha512_notification()
    {
        $this->sample['wpf']['signature'] = hash('sha512', "{$this->sample['wpf']['wpf_unique_id']}$this->password");

        $this->shouldNotThrow()->during('parseNotification', array($this->sample['wpf']));

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
        $this->getNotificationObject()->offsetGet('sig3')->shouldBe($this->sample['api']['signature'] . '3');
        $this->getNotificationObject()->offsetGet('sigU')->shouldBe('u' . $this->sample['api']['signature']);
        $this->getNotificationObject()->offsetGet('$alpha')->shouldBe('');
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
        $this->getNotificationObject()->offsetGet('sig3')->shouldBe($this->sample['wpf']['signature'] . '3');
        $this->getNotificationObject()->offsetGet('sigU')->shouldBe('u' . $this->sample['wpf']['signature']);
        $this->getNotificationObject()->offsetGet('$alpha')->shouldBe('');
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

    public function it_when_transaction_with_terminal_token_assignment()
    {
        $this->parseNotification($this->sample['api']);

        $this->getTerminalToken()->shouldBe($this->terminal_token);
    }

    public function it_when_transaction_with_unique_id_assignment()
    {
        $this->parseNotification($this->sample['api']);

        $this->getUniqueId()->shouldBe($this->unique_id);
    }

    public function it_when_wpf_with_terminal_token_assignment()
    {
        $this->parseNotification($this->sample['wpf']);

        $this->getTerminalToken()->shouldBe($this->terminal_token);
    }

    public function it_when_wpf_with_unique_id_assignment()
    {
        $this->parseNotification($this->sample['wpf']);

        $this->getUniqueId()->shouldBe($this->wpf_unique_id);
    }

    public function it_when_transaction_with_token_configuration()
    {
        Config::setToken(null);
        $this->parseNotification($this->sample['api']);

        $this->shouldBeTokenConfiguredWith($this->terminal_token);
    }

    public function it_when_transaction_with_previously_defined_token()
    {
        Config::setToken('123456');
        $this->parseNotification($this->sample['api']);

        $this->shouldBeTokenConfiguredWith('123456');
    }

    public function getMatchers(): array
    {
        return array(
            'beEmpty' => function ($subject) {
                return empty($subject);
            },
            'contain' => function ($subject, $arg) {
                return (stripos($subject, $arg) !== false);
            },
            'beTokenConfiguredWith' => function($subject, $arg) {
                return Config::getToken() === $arg;
            }
        );
    }
}
