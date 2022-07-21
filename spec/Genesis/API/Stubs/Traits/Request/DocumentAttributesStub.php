<?php

namespace spec\Genesis\API\Stubs\Traits\Request;

use Genesis\API\Traits\Request\DocumentAttributes;

/**
 * Class DocumentAttributesStub
 *
 * Used to spec DocumentAttributes trait
 *
 * @package spec\Genesis\API\Traits\Request
 */
class DocumentAttributesStub
{
    use DocumentAttributes {
        getDocumentIdConditions as public;
    }
}
