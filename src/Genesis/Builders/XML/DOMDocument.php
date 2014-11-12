<?php
/**
 * DOMDocument Builder Interface
 *
 * @package Genesis
 * @subpackage Builders
 */

namespace Genesis\Builders\XML;

use Genesis\Builders\BuilderInterface as BuilderInterface;

final class DOMDocument implements BuilderInterface
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
