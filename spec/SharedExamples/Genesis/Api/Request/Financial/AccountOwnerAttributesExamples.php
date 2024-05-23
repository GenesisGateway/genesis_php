<?php


namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use spec\SharedExamples\Faker;

/**
 * Trait AccountOwnerAttributesExamples
 * @package spec\SharedExamples\Genesis\Api\Request\Financial
 */
trait AccountOwnerAttributesExamples
{
    public function it_should_contain_account_first_name()
    {
        $name = Faker::getInstance()->firstName();

        $this->setRequestParameters();
        $this->setAccountFirstName($name);

        $this->getDocument()->shouldContain("<first_name>$name</first_name>");
    }

    public function it_should_contain_account_middle_name()
    {
        $name = Faker::getInstance()->lastName();

        $this->setRequestParameters();
        $this->setAccountMiddleName($name);

        $this->getDocument()->shouldContain("<middle_name>$name</middle_name>");
    }

    public function it_should_contain_account_last_name()
    {
        $name = Faker::getInstance()->lastName();

        $this->setRequestParameters();
        $this->setAccountLastName($name);

        $this->getDocument()->shouldContain("<last_name>$name</last_name>");
    }
}
