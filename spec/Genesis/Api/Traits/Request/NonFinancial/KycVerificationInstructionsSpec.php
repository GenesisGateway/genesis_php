<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\KycVerificationInstructionsStub;
use spec\SharedExamples\Faker;

class KycVerificationInstructionsSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(KycVerificationInstructionsStub::class);
    }

    public function it_should_set_allow_paper_based_correctly()
    {
        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowPaperBased',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowPaperBased',
            [1]
        );
    }

    public function it_should_set_allow_photocopy_correctly()
    {
        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowPhotocopy',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowPhotocopy',
            [1]
        );
    }

    public function it_should_set_allow_laminated_correctly()
    {
        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowLaminated',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowLaminated',
            [1]
        );
    }

    public function it_should_set_allow_screenshot_correctly()
    {
        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowScreenshot',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowScreenshot',
            [1]
        );
    }

    public function it_should_set_allow_cropped_correctly()
    {
        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowCropped',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowCropped',
            [1]
        );
    }

    public function it_should_set_allow_scanned_correctly()
    {
        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowScanned',
            [Faker::getInstance()->boolean()]
        );

        $this->shouldNotThrow()->during(
            'setVerificationInstructionsAllowScanned',
            [1]
        );
    }
}
