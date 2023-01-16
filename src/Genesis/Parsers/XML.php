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
namespace Genesis\Parsers;

use Genesis\Parser;

/**
 * Class XML
 *
 * Parse an XML Document into a stdClass
 *
 * @package Genesis\Parsers
 */
final class XML implements \Genesis\Interfaces\Parser
{
    /**
     * Converted XML
     *
     * @var \stdClass
     */
    public $stdClassObj;

    /**
     * Should we skip the RootNode?
     *
     * @var bool
     */
    public $skipRootNode;

    /**
     * Set default variables
     */
    public function __construct()
    {
        $this->skipRootNode = false;
    }

    /**
     * Get the parsed object
     *
     * @return \stdClass
     */
    public function getObject()
    {
        return $this->stdClassObj;
    }

    /**
     * Set skipRootNode to true
     *
     * @return bool
     */
    public function skipRootNode()
    {
        return $this->skipRootNode = true;
    }

    /**
     * Parse a document to an stdClass
     *
     * @param string $xmlDocument XML Document
     *
     * @return void
     */
    public function parseDocument($xmlDocument)
    {
        $hasAttributes = false;

        $reader = new \XMLReader();
        $reader->XML($xmlDocument);

        if ($this->skipRootNode) {
            if ($reader->read() && $reader->hasAttributes) {
                $hasAttributes = true;
            }
        }

        $this->stdClassObj = self::readerLoop($reader, $hasAttributes);
    }

    /**
     * Read through the entire document
     *
     * @param \XMLReader $reader
     * @param bool $processRootAttributes
     * @return mixed
     */
    public function readerLoop($reader, $processRootAttributes = false)
    {
        $tree = new \stdClass();

        if ($processRootAttributes === true) {
            $this->processNodeAttributes($reader, $tree);
        }

        while ($reader->read()) {
            switch ($reader->nodeType) {
                case \XMLReader::END_ELEMENT:
                    return $tree;
                    break;
                case \XMLReader::ELEMENT:
                    $this->processElement($reader, $tree);

                    if ($reader->hasAttributes) {
                        $this->processAttributes($reader, $tree);
                    }
                    break;
                case \XMLReader::TEXT:
                case \XMLReader::CDATA:
                    $tree = \Genesis\Utils\Common::filterBoolean(
                        trim($reader->expand()->textContent)
                    );
                    break;
            }
        }

        return $tree;
    }

    /**
     * Process XMLReader element
     *
     * @param $reader
     * @param $tree
     *
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function processElement(&$reader, &$tree)
    {
        $name = $reader->name;

        if (isset($tree->$name)) {
            if (is_a($tree->$name, 'stdClass')) {
                $currentEl = $tree->$name;

                $tree->$name = new \ArrayObject();

                $tree->$name->append($currentEl);
            }

            if (is_a($tree->$name, 'ArrayObject')) {
                $tree->$name->append(($reader->isEmptyElement) ? '' : $this->readerLoop($reader));
            }
        } else {
            $tree->$name = ($reader->isEmptyElement) ? '' : $this->readerLoop($reader);
        }
    }

    /**
     * Process element attributes
     *
     * @param \XMLReader $reader
     * @param \stdClass $tree
     *
     * @SuppressWarnings(PHPMD.ElseExpression)
     */
    public function processAttributes(&$reader, &$tree)
    {
        $name = $reader->name;

        $node = new \stdClass();

        $node->attr = new \stdClass();

        while ($reader->moveToNextAttribute()) {
            $node->attr->{$reader->name} = $reader->value;
        }

        if (isset($tree->$name) && is_a($tree->$name, 'ArrayObject')) {
            $lastKey = $tree->$name->count() - 1;

            $node->value = $tree->$name->offsetGet($lastKey);
            $tree->$name->offsetSet($lastKey, $node);
        } else {
            $node->value = isset($tree->$name) ? $tree->$name : '';

            $tree->$name = $node;
        }
    }

    /**
     * Process Attributes of node and add them
     * Attributes are added under Parser::SUMMARY_TREE_NODE
     *
     * @param \XMLReader $reader
     * @param \stdClass $tree
     */
    public function processNodeAttributes(&$reader, &$tree)
    {
        $node = new \stdClass();

        while ($reader->moveToNextAttribute()) {
            $node->{$reader->name} = $reader->value;
        }

        $tree->{Parser::SUMMARY_TREE_NODE} = $node;
    }
}
