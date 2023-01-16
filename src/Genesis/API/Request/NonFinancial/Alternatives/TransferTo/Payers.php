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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\API\Request\NonFinancial\Alternatives\TransferTo;

use Genesis\API\Request;
use Genesis\Builder;
use Genesis\Utils\Common as CommonUtils;

/**
 * Class Payers
 * @package Genesis\API\Request\NonFinancial\Alternatives\TransferTo
 */
class Payers extends Request
{

    /**
     * Set configuration for the request
     *
     * @return void
     */
    protected function initConfiguration()
    {
        $this->initXmlConfiguration();

        $this->initApiGatewayConfiguration('transfer_to_payers/payers', false);
    }

    /**
     * Configures a Secured GET Request with Xml body
     *
     * @return void
     */
    protected function initXmlConfiguration()
    {
        $this->config = CommonUtils::createArrayObject(
            [
                'protocol' => Request::PROTOCOL_HTTPS,
                'port'     => Request::PORT_HTTPS,
                'type'     => Request::METHOD_GET,
                'format'   => Builder::XML
            ]
        );
    }
}
