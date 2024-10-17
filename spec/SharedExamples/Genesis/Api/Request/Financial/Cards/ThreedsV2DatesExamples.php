<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\Cards;

use Genesis\Exceptions\ErrorParameter;
use Genesis\Api\Constants\DateTimeFormat;

trait ThreedsV2DatesExamples
{
    public function it_should_not_allow_account_creation_date_in_future()
    {
        $today = new \DateTime('+1 day');
        $dateInFuture = $today->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setRequestParameters();
        $this->setThreedsV2CardHolderAccountCreationDate($dateInFuture);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_allow_account_last_change_date_in_future()
    {
        $today = new \DateTime('+1 day');
        $dateInFuture = $today->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setRequestParameters();
        $this->setThreedsV2CardHolderAccountLastChangeDate($dateInFuture);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_allow_password_change_date_in_future()
    {
        $today = new \DateTime('+1 day');
        $dateInFuture = $today->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setRequestParameters();
        $this->setThreedsV2CardHolderAccountPasswordChangeDate($dateInFuture);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_allow_shipping_address_date_first_used_in_future()
    {
        $today = new \DateTime('+1 day');
        $dateInFuture = $today->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setRequestParameters();
        $this->setThreedsV2CardHolderAccountShippingAddressDateFirstUsed($dateInFuture);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }

    public function it_should_not_allow_registration_date_in_future()
    {
        $today = new \DateTime('+1 day');
        $dateInFuture = $today->format(DateTimeFormat::DD_MM_YYYY_L_HYPHENS);

        $this->setRequestParameters();
        $this->setThreedsV2CardHolderAccountRegistrationDate($dateInFuture);
        $this->shouldThrow(ErrorParameter::class)->during('getDocument');
    }
}
