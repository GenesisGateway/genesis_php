<?php

namespace spec\Genesis\Network\Stubs\Traits;

use Genesis\Config;

trait GraphqlServiceUrl
{
    protected function getGraphqlServiceUrl(
        $service_name,
        $version = 'v1',
        $subdomain = 'api_service'
    )
    {
        Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);

        return sprintf(
            'https://%s%s/%s/%s/graphql',
            Config::getSubDomain($subdomain),
            Config::getEndpoint(),
            $service_name,
            $version
        );
    }
}
