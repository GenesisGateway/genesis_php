<?php

namespace spec\Genesis\API\Traits\Request\Financial\Threeds\V2;

use Genesis\API\Constants\Transaction\Parameters\Threeds\V2\Purchase\Categories;
use PhpSpec\ObjectBehavior;
use spec\Genesis\API\Stubs\Traits\Request\Financial\Threeds\V2\PurchaseStub;
use spec\SharedExamples\Faker;

/**
 * Class PurchaseAttrbutesSpec
 * @package spec\Genesis\API\Traits\Request\Financial\Threeds\V2
 */
class PurchaseAttrbutesSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(PurchaseStub::class);
    }

    public function it_should_return_params_structure()
    {
        $this->getStructure()->shouldBeArray();
        $this->getStructure()->shouldBeNotEmptyArray();
    }

    public function it_should_return_correct_structure()
    {
        $this->getStructure()->shouldHaveKey('category');
    }

    public function it_should_set_correct_category()
    {
        $category = Faker::getInstance()->randomElement(Categories::getAll());

        $this->setThreedsV2PurchaseCategory($category)->shouldHaveType(PurchaseStub::class);
        $this->getThreedsV2PurchaseCategory()->shouldBe($category);
    }

    public function getMatchers(): array
    {
        return array(
            'beNotEmptyArray' => function ($subject) {
                return is_array($subject) && count($subject) > 0;
            }
        );
    }
}
