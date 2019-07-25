<?php
/*
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
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis\API\Request\Base\NonFinancial\Consumers;

use Genesis\API\Request\Base\BaseVersionedRequest;
use Genesis\Builder;

/**
 * Class BaseRequest
 *
 * The Consumer entity brings Tokenization, Transactions and Web Payment Forms (WPF) together.
 * It is a representation of a customer that can serve different purposes.
 * A consumer is identified by providing both consumer ID and email.
 * It is explicitly created via our Consumer API or implicitly by providing customer_email
 * in either Transactions or WPF APIs.
 *
 * @package Genesis\API\Request\Base\NonFinancial\Consumers
 */
abstract class BaseRequest extends BaseVersionedRequest
{
    /**
     * Consumer constructor.
     *
     * @param string $requestPath
     */
    public function __construct($requestPath)
    {
        parent::__construct($requestPath, Builder::XML, ['v1']);
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $treeStructure = [
            $this->getRequestPath() . '_request' => $this->getRequestStructure()
        ];

        $this->treeStructure = \Genesis\Utils\Common::createArrayObject($treeStructure);
    }
}
