<?php

namespace spec\Genesis\Api\Stubs\Traits\Request;

use Genesis\Api\Traits\Request\DocumentAttributes;

/**
 * Class DocumentAttributesStub
 *
 * Used to spec DocumentAttributes trait
 *
 * @package spec\Genesis\Api\Traits\Request
 */
class DocumentAttributesStub
{
    use DocumentAttributes {
        getDocumentIdConditions as public;
    }
}
