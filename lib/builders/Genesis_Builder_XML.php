<?php

namespace Genesis;


class Genesis_Builder_XML
{
    private $_writer;

    public function __construct()
    {
        $this->_writer = new \XMLWriter();

        $this->_writer->openMemory();
        $this->_writer->startDocument('1.0', 'UTF-8');
        $this->_writer->setIndent(4);
    }

    /**
     * Flush and destroy the Writer upon destruction (just in case)
     */
    public function __destruct()
    {
        $this->_writer->flush(true);
    }

    /**
     * Generate the body of the XML file by providing the request fields
     *
     * @param $fields Array - tree-structured array
     */
    public function generateBody($fields)
    {
        $this->writeData($fields);
    }

    /**
     * Get the generated XML file as string
     *
     * @param bool $flush - should we flush the cache upon returning it?
     * @return string
     */
    public function getOutput($flush = false)
    {
        $this->_writer->endDocument();
        return $this->_writer->outputMemory($flush);
    }

    /**
     * Insert tree-structured array as objects in existing XMLWriter
     *
     * @param $data Array - tree-structured array
     */
    public function writeData($data)
    {
        foreach($data as $key => $value) {
            if(is_array($value)){
                $this->_writer->startElement($key);
                $this->writeData($value);
                $this->_writer->endElement();
                continue;
            }
            $this->_writer->writeElement($key, $value);
        }
    }

    /**
     * Generate an XML representation of given array
     * in a given XML object.
     *
     * @param $xml_nodes_arr    - array with fields to be represented as XML nodes
     * @param $xml_doc_instance - instance of the XML document
     */
    private function array_to_xml($xml_nodes_arr, &$xml_doc_instance) {
        foreach($xml_nodes_arr as $key => $value) {
            if(is_array($value))
            {
                if(!is_numeric($key))
                {
                    $subnode = $xml_doc_instance->addChild("$key");
                    $this->array_to_xml($value, $subnode);
                }
                else
                {
                    $subnode = $xml_doc_instance->addChild("item$key");
                    $this->array_to_xml($value, $subnode);
                }
            }
            else
            {
                $xml_doc_instance->addChild("$key",htmlspecialchars("$value"));
            }
        }
    }
} 