<?php

namespace spec\Genesis\API\Request\Base;

use Genesis\API\Constants\Endpoints;
use Genesis\Config;
use spec\Genesis\API\Stubs\Base\Request\GraphQLRequestStub;

class GraphQLRequestSpec extends \PhpSpec\ObjectBehavior
{
    public function let()
    {
        $this->beAnInstanceOf(GraphQLRequestStub::class);
    }

    public function it_should_set_version_correctly()
    {
        $this->shouldNotThrow()->during(
            'setVersion',
            ['v1']
        );
    }

    public function it_should_fail_if_version_is_invalid()
    {
        $this->shouldThrow()->during(
            'setVersion',
            ['v100']
        );
    }

    public function it_should_init_proper_configuration()
    {
        Config::setEndpoint(Endpoints::EMERCHANTPAY);
        $this->setVersion('v1');

        $this->getApiConfig('url')->shouldBe(
            "https://staging.api.emerchantpay.net:443/test/v1/graphql"
        );
    }

    public function it_should_have_proper_request_type()
    {
        $this->getRequestType()->shouldBe('json');
    }

    public function it_should_create_proper_graphql_element()
    {
        $this->publicGenerateGraphQLCode(
                ['element' => 'value', 'element2' => 'value2'],
                'test',
                ', ',
                '%s: %s'
            )->shouldBe('test: { element: value, element2: value2 }');
    }

    public function it_should_populate_proper_transaction_structure()
    {
        $this->getDocument()->shouldContain('query');
        $this->getDocument()->shouldContain('filter');
        $this->getDocument()->shouldContain('items');
    }
}
