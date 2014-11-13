<?php
/**
 * Builder handler
 *
 * @package Genesis
 * @subpackage Builders
 */

namespace Genesis\Builders;

class Builder
{
    /**
     * Instance of the selected builder wrapper
     *
     * @var object
     */
    private $context;

    /**
     * Initialize the required builder, based on the use's
     * preference (set inside the configuration ini file)
     */
    public function __construct()
    {
        $interface = \Genesis\GenesisConfig::getInterfaceSetup('builder');

        switch ($interface) {
            case 'xml_domdocument';
                $this->context = new XML\DOMDocument();
                break;
            default:
            case 'xml_writer':
                $this->context = new XML\XMLWriter();
                break;
        }
    }

    /**
     * Get the printable Builder Output
     *
     * @return string
     */
    public function getDocument()
    {
        return $this->context->getOutput();
    }

    /**
     * Parse tree-structure into Builder document
     *
     * @param array $structure
     */
    public function parseStructure(Array $structure)
    {
        $this->context->populateNodes($structure);
    }
}
