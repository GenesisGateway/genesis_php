<?php

namespace spec\Genesis\Api\Stubs\Base\Request\NonFinancial;

use Genesis\Api\Request\Base\NonFinancial\DateRangeRequest as BaseDateRangeRequest;

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
