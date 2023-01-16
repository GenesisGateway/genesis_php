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
namespace Genesis\Builders;

/**
 * XMLWriter Builder Interface
 * Note: requires libxml2 support (either built-in or as extension)
 *
 * @package    Genesis
 * @subpackage Builders
 */
final class XML implements \Genesis\Interfaces\Builder
{
    /**
     * Store the XMLWriter instance
     *
     * @var \XMLWriter
     */
    public $context;

    /**
     * Store the Generated Document
     *
     * @var string
     */
    private $output;

    /**
     * Set and instantiate new UTF-8 XML document
     */
    public function __construct()
    {
        $this->context = new \XMLWriter();

        $this->context->openMemory();
        $this->context->startDocument('1.0', 'UTF-8');
        $this->context->setIndent(true);
        $this->context->setIndentString("\x20\x20");
    }

    /**
     * Insert tree-structured array as nodes in XMLWriter
     * and end the current Document.
     *
     * @param array $data - tree-structured array
     *
     * @throws \Genesis\Exceptions\InvalidArgument
     *
     * @return void
     */
    public function populateNodes($data)
    {
        if (!\Genesis\Utils\Common::isValidArray($data)) {
            throw new \Genesis\Exceptions\InvalidArgument('Invalid data structure');
        }

        // Ensure that the Array position is 0
        reset($data);

        $this->iterateArray(key($data), reset($data));

        // Finish the document
        $this->context->endDocument();

        $this->output = $this->context->outputMemory(true);
    }

    /**
     * Get Builder output
     *
     * @return string XML Document
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * Recursive iteration over array
     *
     * @param string $name name of the current leave
     * @param array  $data value of the current leave
     *
     * @return void
     */
    public function iterateArray($name, $data)
    {
        if (\Genesis\Utils\Common::isValidXMLName($name)) {
            $this->context->startElement($name);
        }

        foreach ($data as $key => $value) {
            if (is_null($value)) {
                continue;
            }

            // Note: XMLWriter discards Attribute writes if they are written
            // after an Element, so make sure the attributes are at the top
            if ($key === '@attributes') {
                $this->writeAttribute($value);
                continue;
            }

            if ($key === '@cdata') {
                $this->writeCData($value);
                continue;
            }

            if ($key === '@value') {
                $this->writeText($value);
                continue;
            }

            $this->writeElement($key, $value);
        }

        if (\Genesis\Utils\Common::isValidXMLName($name)) {
            $this->context->endElement();
        }
    }

    /**
     * Write Element's Attribute
     *
     * @param $value
     */
    public function writeAttribute($value)
    {
        if (is_array($value)) {
            foreach ($value as $attrName => $attrValue) {
                $this->context->writeAttribute($attrName, $attrValue);
            }
        }
    }

    /**
     * Write Element's CData
     *
     * @param $value
     *
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function writeCData($value)
    {
        if (is_array($value)) {
            foreach ($value as $attrValue) {
                $this->context->writeCData($attrValue);
            }
        } else {
            $this->context->writeCData($value);
        }
    }

    /**
     * Write Element's Text
     *
     * @param $value
     *
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function writeText($value)
    {
        if (is_array($value)) {
            foreach ($value as $attrValue) {
                $this->context->text($attrValue);
            }
        } else {
            $this->context->text($value);
        }
    }

    /**
     * Write XML Element
     *
     * @param $key
     * @param $value
     *
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function writeElement($key, $value)
    {
        if (is_array($value)) {
            $this->iterateArray($key, $value);
        } else {
            $value = \Genesis\Utils\Common::booleanToString($value);

            $this->context->writeElement($key, $value);
        }
    }
}
