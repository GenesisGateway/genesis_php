<?php

namespace Genesis\Utils\Builders;

final class DOMDocument
{
    private $xmlDocument;

    public function __construct()
    {
        $this->xmlDocument = new \DOMDocument('1.0', 'UTF-8');
        $this->xmlDocument->formatOutput        = true;
        $this->xmlDocument->preserveWhiteSpace  = true;
    }

    public function __destruct()
    {
        if (isset($this->xmlDocument))
            $this->xmlDocument = null;
    }

    /**
     * Insert tree-structured Array as nodes in XMLWriter
     *
     * @param $data Array - Tree structure Array
     * @param $domElement \DOMDocument - current \DOMDocument node
     */
    public function populateXMLNodes($data, $domElement = null)
    {
        $domElement = is_null($domElement) ? $this->xmlDocument : $domElement;

        if (is_array($data)) {
            foreach( $data as $index => $mixedElement ) {

                if ( is_int($index) ) {
                    $node = $domElement;
                }
                else {
                    $node = $this->xmlDocument->createElement($index);
                    $domElement->appendChild($node);
                }

                $this->populateXMLNodes($mixedElement, $node);
            }
        }
        else {
            $domElement->appendChild($this->xmlDocument->createTextNode($data));
        }
    }

    /**
     * Dummy function to make the DOMDocument class interchangeable with XMLWriter
     */
    public function finalizeXML()
    {

    }

    /**
     * Get the XML output
     *
     * @return mixed
     */
    public function getOutput()
    {
        return $this->xmlDocument->saveXML();
    }
}
