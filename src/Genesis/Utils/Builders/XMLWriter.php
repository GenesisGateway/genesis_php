<?php

namespace Genesis\Utils\Builders;

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
        if (isset($this->xmlWriter))
            $this->xmlWriter->flush();
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
            if (is_null($value))
            {
                continue;
            }

            if (is_array($value))
            {
                if (is_int($key))  {
                    $this->populateXMLNodes($value);
                }
                else {
                    $this->xmlWriter->startElement($key);
                    $this->populateXMLNodes($value);
                    $this->xmlWriter->endElement();
                }
                continue;
            }

            $this->xmlWriter->writeElement($key, $value);
        }
        $this->xmlWriter->endDocument();
    }

    /**
     * Get the XML output
     *
     * @return mixed
     */
    public function getOutput()
    {
        return $this->xmlWriter->outputMemory();
    }
}
