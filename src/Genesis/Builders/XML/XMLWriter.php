<?php

namespace Genesis\Builders\XML;

final class XMLWriter
{
    private $xmlWriter;

    /**
     * Instantiate and start an empty XML Document
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
        if (isset($this->xmlWriter)) {
            $this->xmlWriter->flush();
        }
    }

    /**
     * Insert tree-structured array as nodes in XMLWriter
     *
     * @param $data Array - tree-structured array
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
                    $this->xmlWriter->startElement($key);
                    $this->populateNodes($value);
                    $this->xmlWriter->endElement();
                }
                continue;
            }

            $this->xmlWriter->writeElement($key, $value);
        }
    }

    /**
     * Close the root node
     */
    public function finalizeDocument()
    {
        $this->xmlWriter->endDocument();
    }

    /**
     * Get XML output
     *
     * @return mixed
     */
    public function getOutput()
    {
        $contents = html_entity_decode($this->xmlWriter->outputMemory());
        return $contents;
    }
}
