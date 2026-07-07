<?php

namespace spec\Genesis\Utils;

use PhpSpec\ObjectBehavior;

class RequirementsSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Genesis\Utils\Requirements');
    }

    public function it_can_pass_system_requirements()
    {
        $this->shouldNotThrow()->during('verify');
    }

    public function it_can_verify_function_existence()
    {
        $this->shouldNotThrow()->during('isFunctionExists', array('phpinfo', 'FUNCTION_NOT_FOUND'));
    }

    public function it_can_verify_method_existence()
    {
        $this->shouldNotThrow()->during('isMethodExists', array($this, 'verify', 'METHOD_NOT_FOUND'));
    }

    public function it_can_verify_class_existence()
    {
        $this->shouldNotThrow()->during('isClassExists', array('\Genesis\Genesis', 'CLASS_NOT_FOUND'));
    }

    public function it_can_return_correct_error_message()
    {
        $error_message = 'Unsupported PHP version, please upgrade!' . PHP_EOL .
                         'This library requires PHP version 5.5.9 or newer.';

        $this::getErrorMessage('system')->shouldBe($error_message);
    }

    public function it_should_return_fallback_message_for_null_name()
    {
        $this::getErrorMessage(null)->shouldBe('[] Missing project dependency!');
    }

    public function it_should_not_trigger_deprecation_for_get_error_message_with_null()
    {
        $deprecations = array();
        set_error_handler(function ($errno, $errstr) use (&$deprecations) {
            $deprecations[] = $errstr;
        }, E_DEPRECATED | E_USER_DEPRECATED);

        \Genesis\Utils\Requirements::getErrorMessage(null);

        restore_error_handler();

        if (!empty($deprecations)) {
            throw new \Exception(
                'Deprecation notice triggered: ' . implode('; ', $deprecations)
            );
        }
    }
}
