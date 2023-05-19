<?php

namespace spec\SharedExamples\Genesis\API\Request\Financial\OnlineBankingPayments;

use spec\SharedExamples\Faker;

trait UserCategoryAttributesExamples
{
    public function it_should_contain_user_category_when_set()
    {
        $this->setRequestParameters();

        $fakeUserCategory = Faker::getInstance()->text();
        $this->setUserCategory($fakeUserCategory);

        $this->shouldNotThrow()->during('getDocument');
        $this->getDocument()->shouldContain("<user_category>$fakeUserCategory</user_category>");
    }
}
