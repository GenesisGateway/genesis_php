<?php
/**
 * XMLWriter Builder Interface
 * Note: requires libxml2 support
 *
 * @package Genesis
 * @subpackage Builders
 */

namespace Genesis\Builders\XML;

use Genesis\Builders\BuilderInterface as BuilderInterface;

final class XMLWriter implements BuilderInterface
{
    /**
     * Store the XMLWriter instance
     *
     * @var \XMLWriter
     */
    private $context;

    /**
     * Set and instantiate new UTF-8 XML document
     */
    public function __construct()
    {
        $this->context = new \XMLWriter();

        $this->context->openMemory();
        $this->context->startDocument('1.0', 'UTF-8');
        $this->context->setIndent(4);
    }

    /**
     * Flush and destroy XMLWriter instance upon destruction
     */
    public function __destruct()
    {
        if (isset($this->context)) {
            $this->context->flush();
        }
    }

    /**
     * Insert tree-structured array as nodes in XMLWriter
     *
     * @param $data Array - tree-structured array
     * @return void
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
                    $this->context->startElement($key);
                    $this->populateNodes($value);
                    $this->context->endElement();
                }
                continue;
            }

            $this->context->writeElement($key, $value);
        }
    }

    /**
     * Get Builder output
     *
     * @return mixed
     */
    public function getOutput()
    {
        $this->context->endDocument();
        return html_entity_decode($this->context->outputMemory(false));
    }
}
