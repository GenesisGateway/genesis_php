<?php

namespace spec\Genesis\Api\Traits\Request\NonFinancial;

use PhpSpec\ObjectBehavior;
use spec\Genesis\Api\Stubs\Traits\Request\NonFinancial\KycBusinessStub;
use spec\SharedExamples\Faker;

/**
 * Class KycBusinessSpec
 *
 * @package spec\Genesis\Api\Traits\Request\NonFinancial
 */
class KycBusinessSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(KycBusinessStub::class);
    }

    public function it_should_set_background_checks_verifications_business_name()
    {
        $this->shouldNotThrow()->during(
            'setBackgroundChecksVerificationsBusinessName',
            [Faker::getInstance()->company()]
        );
    }

    public function it_should_set_background_checks_verifications_business_incorporation_date()
    {
        $this->shouldNotThrow()->during(
            'setBackgroundChecksVerificationsBusinessIncorporationDate',
            [Faker::getInstance()->date('Y-m-d')]
        );

        $this->shouldNotThrow()->during(
            'setBackgroundChecksVerificationsBusinessIncorporationDate',
            ['']
        );
    }
}
