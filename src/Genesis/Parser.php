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
namespace Genesis;

use Genesis\Parsers\JSON;
use Genesis\Parsers\XML;

/**
 * Parser handler
 *
 * @package Genesis
 */
class Parser
{
    const JSON_INTERFACE    = 'json';
    const XML_INTERFACE     = 'xml';
    const SUMMARY_TREE_NODE = 'summary';
    /**
     * Instance of the selected builder wrapper
     *
     * @var object
     */
    private $context;

    /**
     * Initialize the required builder, based on the use's
     * preference (set inside the configuration ini file)
     *
     * @param string $interface
     */
    public function __construct($interface = null)
    {
        $interface = $interface ?: \Genesis\Config::getInterface('parser');

        switch ($interface) {
            default:
            case self::XML_INTERFACE:
                $this->context = new XML();
                break;
            case self::JSON_INTERFACE:
                $this->context = new JSON();
                break;
        }
    }

    /**
     * Get the printable Builder Output
     *
     * @return \stdClass
     */
    public function getObject()
    {
        return $this->context->getObject();
    }

    /**
     * Parse tree-structure into Builder document
     *
     * @param mixed $document
     */
    public function parseDocument($document)
    {
        $this->context->parseDocument($document);
    }

    /**
     * Set a flag, indicating, if the root
     * node of a document should be skipped
     * during parsing
     *
     * @return bool
     */
    public function skipRootNode()
    {
        $this->context->skipRootNode();
    }
}
