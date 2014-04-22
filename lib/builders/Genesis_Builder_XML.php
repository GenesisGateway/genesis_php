<?php

namespace Genesis;


class Genesis_Builder_XML
{
    private $xmlWriter;
    private $xmlDocument;

    /**
     * Instantiate and start an empty XML Document
     *
     */
    public function __construct()
    {
        $this->xmlWriter = new \XMLWriter();

        $this->xmlWriter->openMemory();
        $this->xmlWriter->startDocument('1.0', 'UTF-8');
        $this->xmlWriter->setIndent(4);
    }

    /**
     * Flush and destroy XMLWriter instance upon destruction
     */
    public function __destruct()
    {
        $this->xmlWriter->flush(true);
    }

    /**
     * Insert tree-structured array as nodes in XMLWriter
     *
     * @param $data Array - tree-structured array
     */
    public function populateXMLNodes($data)
    {
        foreach($data as $key => $value)
        {
            // Skip null nodes as this
            // only increases the body
            // length in the request
            if (is_null($value))
            {
                continue;
            }

            if (is_array($value))
            {
                $this->xmlWriter->startElement($key);
                $this->populateXMLNodes($value);
                $this->xmlWriter->endElement();
                continue;
            }

            $this->xmlWriter->writeElement($key, $value);
        }
    }

    /**
     * Close the document and save the XML output
     *
     * @param bool $flush - flush the memory after returning the contents
     * @return string
     */
    public function finishDocument($flush = false)
    {
        $this->xmlWriter->endDocument();
        $this->xmlDocument = $this->xmlWriter->outputMemory($flush);
        var_dump($this->xmlDocument);
    }

    /**
     * Get the XML output
     *
     * @return mixed
     */
    public function getOutput()
    {
        return $this->xmlDocument;
    }
} 