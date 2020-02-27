<?php

namespace spec\Genesis\API\Stubs\Base\Request\NonFinancial;

use Genesis\API\Request\Base\NonFinancial\DateRangeRequest as BaseDateRangeRequest;

class DateRangeRequestStub extends BaseDateRangeRequest
{
    protected function getRequestStructure()
    {
        return [
            'key' => 'value'
        ];
    }

    protected function getParentNode()
    {
        return 'root_node';
    }
}
