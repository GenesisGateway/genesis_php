<?php

/**
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Request\Base\Financial\Cards;

use Genesis\Api\Traits\Request\Financial\MpiAttributes;
use Genesis\Api\Traits\Request\Financial\Threeds\V2\AllAttributes as AllThreedsV2Attributes;

/**
 * Class CreditCard3D
 * @package Genesis\Api\Request\Base\Financial\Cards
 *
 */
abstract class CreditCard3D extends CreditCard
{
    use AllThreedsV2Attributes;
    use MpiAttributes;

    /**
     * Return required conditional 3DS fields
     *
     * @return array
     */
    protected function required3DSFieldsConditional()
    {
        return array_merge(
            $this->requiredMpiFieldsConditional(),
            $this->requiredThreedsV2DeviceTypeConditional()
        );
    }

    /**
     * Return required 3DS fields groups
     *
     * @return array
     */
    protected function required3DSFieldsGroups()
    {
        return [
            'asynchronous' => ['mpi_eci']
        ];
    }

    /**
     * Return 3DS request attributes
     * @return array
     */
    protected function get3DSTransactionAttributes()
    {
        return [
            'mpi_params'        => $this->getMpiParamsStructure(),
            'threeds_v2_params' => $this->getThreedsV2ParamsStructure()
        ];
    }
}
