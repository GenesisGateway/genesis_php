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
 * XMLWriter Builder Interface
 * Note: requires libxml2 support (either built-in or as extension)
 *
 * @package Genesis
 * @subpackage Builders
 */
final class XMLWriter implements \Genesis\Builders\BuilderInterface
{
    /**
     * Store the XMLWriter instance
     *
     * @var \XMLWriter
     */
    private $context;

    /**
     * Set and instantiate new UTF-8 XML document
     */
    public function __construct()
    {
        $this->context = new \XMLWriter();

        $this->context->openMemory();
        $this->context->startDocument('1.0', 'UTF-8');
        $this->context->setIndent(4);
    }

    /**
     * Flush and destroy XMLWriter instance upon destruction
     */
    public function __destruct()
    {
        if (isset($this->context)) {
            $this->context->flush();
        }
    }

    /**
     * Insert tree-structured array as nodes in XMLWriter
     *
     * @param $data Array - tree-structured array
     * @return void
     */
    public function populateNodes($data)
    {
        foreach($data as $key => $value)
        {
            if (is_null($value)) {
                continue;
            }

            if (is_array($value)) {
                if (is_int($key))  {
                    $this->populateNodes($value);
                }
                else {
                    $this->context->startElement($key);
                    $this->populateNodes($value);
                    $this->context->endElement();
                }
                continue;
            }

            $this->context->writeElement($key, $value);
        }
    }

    /**
     * Get Builder output
     *
     * @return mixed
     */
    public function getOutput()
    {
        $this->context->endDocument();
        return $this->context->outputMemory(false);
    }
}
