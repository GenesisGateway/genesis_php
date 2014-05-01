<?php

namespace Genesis\Builders\XML;

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
        if (isset($this->xmlDocument)) {
            $this->xmlDocument = null;
        }
    }

    /**
     * Parse tree-structured Array as nodes in XMLWriter
     *
     * @param $data
     * @param $domElement \DOMDocument - current \DOMDocument node
     */
    public function populateNodes($data, $domElement = null)
    {
        $domElement = is_null($domElement) ? $this->xmlDocument : $domElement;

        if (is_array($data)) {
            foreach( $data as $index => $mixedElement )
            {
                if ( is_int($index) ) {
                    $node = $domElement;
                }
                else {
                    $node = $this->xmlDocument->createElement($index);
                    $domElement->appendChild($node);
                }

                $this->populateNodes($mixedElement, $node);
            }
        }
        else {
            $domElement->appendChild($this->xmlDocument->createTextNode($data));
        }
    }

    /**
     * Get XML output
     *
     * @return mixed
     */
    public function getOutput()
    {
        return $this->xmlDocument->saveXML();
    }
}
