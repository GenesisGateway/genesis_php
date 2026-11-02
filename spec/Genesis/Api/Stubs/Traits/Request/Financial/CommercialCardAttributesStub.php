<?php

namespace spec\Genesis\Api\Stubs\Traits\Request\Financial;

use Genesis\Api\Traits\MagicAccessors;
use Genesis\Api\Traits\Request\Financial\CommercialCardAttributes;
use Genesis\Api\Traits\RestrictedSetter;

/**
 * Class CommercialCardAttributesStub
 *
 * Used to spec CommercialCardAttributes Trait
 *
 * @package spec\Genesis\Api\Traits\Request\Financial
 */
class CommercialCardAttributesStub
{
    use CommercialCardAttributes;
    use MagicAccessors;
    use RestrictedSetter;

    /**
     * Expose the Commercial Card Data validation
     *
     * @return void
     * @throws \Genesis\Exceptions\ErrorParameter
     */
    public function publicValidateCommercialCardAttributes()
    {
        $this->validateCommercialCardAttributes();
    }

    /**
     * Fields allowed to hold an empty, not null value (e.g. zero total discount amount)
     *
     * @return array
     */
    protected function allowedEmptyNotNullFields()
    {
        return $this->getCommercialCardAllowedFieldsZeroValues();
    }
}
