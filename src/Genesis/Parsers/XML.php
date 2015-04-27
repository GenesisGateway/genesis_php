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
namespace Genesis\Parsers;

/**
 * Class XML
 *
 * Parse an XML Document into a stdClass
 *
 * @package Genesis\Parsers
 */
class XML
{
    /**
     * Converted XML
     *
     * @var \stdClass
     */
    private $stdClassObj;

    /**
     * SimpleXmlIterator instance
     *
     * @var \SimpleXmlIterator
     */
    private $sxi;

    /**
     * @param string $xml_document XML Document
     */
    public function __construct($xml_document)
    {
        $this->sxi = new \SimpleXmlIterator($xml_document);

        $this->stdClassObj = self::sxiToClass($this->sxi);
    }

    /**
     * Iterate over the elements and return object
     * representing the tree structure
     *
     * @param \SimpleXMLIterator $sxi
     * @param array              $isMultiNode
     *
     * @return \stdClass|mixed
     */
    public static function sxiToClass($sxi, $isMultiNode = array())
    {
        $stdObj = new \stdClass();

        if ($sxi->attributes()->count() > 0) {
            $stdObj = json_decode(json_encode($sxi->attributes()));
        }

        for ($sxi->rewind(); $sxi->valid(); $sxi->next()) {
            if (!empty($isMultiNode)) {
                if (!isset($stdObj->{$sxi->key()})) {
                    $stdObj->{$sxi->key()} = array();
                }

                if ($sxi->hasChildren()) {
                    array_push($stdObj->{$sxi->key()}, self::sxiToClass($sxi->current(),
                        self::checkForDuplicates($sxi->current())));
                } else {
                    if (count($sxi->current()->attributes()) > 0) {
                        $object = json_decode(json_encode($sxi->current()));

                        $content = trim($sxi->current()->__toString());

                        if (!empty($content)) {
                            $object->content = $content;
                        }
                    } else {
                        $object = $sxi->current()->__toString();
                    }

                    if (in_array($sxi->key(), $isMultiNode)) {
                        array_push($stdObj->{$sxi->key()}, $object);
                    } else {
                        $stdObj->{$sxi->key()} = $object;
                    }

                }
            } else {
                if ($sxi->hasChildren()) {
                    $stdObj->{$sxi->key()} = self::sxiToClass($sxi->current(),
                        self::checkForDuplicates($sxi->current()));
                } else {
                    $content = trim($sxi->current()->__toString());

                    if (count($sxi->current()->attributes()) > 0) {
                        $object = json_decode(json_encode($sxi->current()->attributes()));

                        if (!empty($content)) {
                            $object->content = $content;
                        }
                    }

                    $stdObj->{$sxi->key()} = isset($object) ? $object : $content;
                }
            }

        }

        return $stdObj;
    }

    /**
     * Check if there are nodes with duplicate names
     *
     * @param \SimpleXMLIterator $sxi
     *
     * @return array
     */
    public static function checkForDuplicates($sxi)
    {
        $counter = $duplicate_list = array();

        for ($sxi->rewind(); $sxi->valid(); $sxi->next()) {
            if (array_key_exists($sxi->key(), $counter)) {
                $duplicate_list[$sxi->key()] = $sxi->key();
            }

            isset($counter[$sxi->key()]) ? $counter[$sxi->key()]++ : $counter[$sxi->key()] = 0;
        }

        return $duplicate_list;
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
}
