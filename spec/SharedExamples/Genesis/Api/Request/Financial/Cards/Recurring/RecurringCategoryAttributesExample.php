<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\Cards\Recurring;

use Genesis\Api\Constants\Transaction\Parameters\Recurring\Categories;
use spec\SharedExamples\Faker;

trait RecurringCategoryAttributesExample
{
    public function it_should_have_recurring_category()
    {
        $this->setRequestParameters();

        $this->shouldNotThrow()->during(
            'setRecurringCategory',
            [Faker::getInstance()->randomElement(Categories::getAll())]
        );
    }

    public function it_should_contain_recurring_category()
    {
        $this->setRequestParameters();

        $this->setRecurringCategory(Faker::getInstance()->randomElement(Categories::getAll()));

        $this->getDocument()->shouldContain('<recurring_category>');
    }
}
