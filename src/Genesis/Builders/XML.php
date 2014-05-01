<?php

namespace Genesis\Builders;

use \Genesis\Configuration as Configuration;

class XML
{
    /**
     * Instance of the selected builder wrapper
     *
     * @var object
     */
    private $context;

    /**
     * Store printable XML Output
     *
     * @var string
     */
    private $document;

    /**
     * Initialize the required builder, based on the use's
     * preference (set inside the configuration ini file)
     */
    public function __construct()
    {
        $wrapper = Configuration::getWrapper('xml_builder');

        switch ($wrapper) {
            default:
            case 'xml_writer':
                $this->context = new XML\XMLWriter();
                break;
            case 'dom_document';
                $this->context = new XML\DOMDocument();
                break;
        }
    }

    /**
     * Get the printable XML Output
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Parse tree-structure into XML document
     *
     * @param array $structure
     */
    public function parseStructure(Array $structure)
    {
        $this->context->populateNodes($structure);

        if (method_exists($this->context, 'finalizeDocument')) {
            $this->context->finalizeDocument();
        }

        $this->document = $this->context->getOutput();
    }
}
