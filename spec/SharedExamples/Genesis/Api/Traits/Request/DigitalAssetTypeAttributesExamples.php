<?php

namespace spec\SharedExamples\Genesis\Api\Traits\Request;

use Genesis\Api\Constants\Transaction\Parameters\DigitalAssetTypes;
use Genesis\Exceptions\InvalidArgument;
use spec\SharedExamples\Faker;

trait DigitalAssetTypeAttributesExamples
{
    public function it_should_not_include_digital_asset_type_when_not_set()
    {
        $this->setRequestParameters();
        $this->setDigitalAssetType(null);
        $this->getDocument()->shouldNotContain('<digital_asset_type>');
    }

    public function it_should_include_digital_asset_type_when_set()
    {
        $digitalAssetType = Faker::getInstance()->randomElement(DigitalAssetTypes::getAll());
        $this->setRequestParameters();
        $this->setDigitalAssetType($digitalAssetType);
        $this->getDocument()->shouldContain('<digital_asset_type>' . $digitalAssetType . '</digital_asset_type>');
    }

    public function it_should_throw_when_invalid_value()
    {
        $this->setRequestParameters();
        $this->shouldThrow(InvalidArgument::class)->during('setDigitalAssetType', ['INVALID_VALUE']);
    }
}
