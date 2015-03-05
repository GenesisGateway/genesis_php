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
namespace Genesis\Builders\XML;

/**
 * DOMDocument Builder Interface
 *
 * @package Genesis
 * @subpackage Builders
 */
final class DOMDocument implements \Genesis\Builders\BuilderInterface
{
    /**
     * Store the DOMDocument instance
     *
     * @var \DOMDocument
     */
    private $context;

    /**
     * Set and instantiate new UTF-8 XML document
     */
    public function __construct()
    {
        $this->context = new \DOMDocument('1.0', 'UTF-8');
        $this->context->formatOutput        = true;
        $this->context->preserveWhiteSpace  = true;
    }

    /**
     * Get Builder output
     *
     * @return mixed
     */
    public function getOutput()
    {
        echo 'call';
        return $this->context->saveXML();
    }

    /**
     * Parse tree-structured Array as nodes
     *
     * @param $data
     * @param $currElement \DOMDocument - current \DOMDocument node
     *
     * @return void
     */
    public function populateNodes($data, $currElement = null)
    {
        $currElement = is_null($currElement) ? $this->context : $currElement;

        if (is_array($data)) {
            foreach( $data as $index => $mixedElement )
            {
                if ( is_int($index) ) {
                    $node = $currElement;
                }
                else {
                    $node = $this->context->createElement($index);
                    $currElement->appendChild($node);
                }

                $this->populateNodes($mixedElement, $node);
            }
        }
        else {
            $currElement->appendChild($this->context->createTextNode($data));
        }
    }
}
