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
namespace Genesis\API\Request\NonFinancial\Consumers;

use Genesis\API\Request\Base\NonFinancial\Consumers\BaseRequest as ConsumerBaseRequest;
use Genesis\Exceptions\ErrorParameter;

/**
 * Class Retrieve
 *
 * Retrieves consumer details based on consumer id or email.
 *
 * @package Genesis\API\Request\NonFinancial\Consumers
 *
 * @method string getEmail()
 * @method string getConsumerId()
 * @method Retrieve setEmail(string $email)
 * @method Retrieve setConsumerId(string $consumerId)
 */
class Retrieve extends ConsumerBaseRequest
{
    /**
     * @var string
     */
    protected $email;

    /**
     * @var int
     */
    protected $consumer_id;

    /**
     * Retrieve constructor.
     */
    public function __construct()
    {
        parent::__construct('retrieve_consumer');
    }

    /**
     * @throws ErrorParameter
     */
    protected function checkRequirements()
    {
        if (empty($this->email) && empty($this->consumer_id)) {
            throw new ErrorParameter('Either email or consumer_id field has to be set.');
        }

        parent::checkRequirements();
    }

    /**
     * @return array
     */
    protected function getRequestStructure()
    {
        return [
            'email'       => $this->email,
            'consumer_id' => $this->consumer_id
        ];
    }
}
