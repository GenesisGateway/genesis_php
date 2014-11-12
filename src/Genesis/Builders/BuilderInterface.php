<?php
/**
 * An interface for every builder abstraction (XMLWriter, DOMDocument, JSON etc.).
 *
 * @package Genesis
 * @subpackage Builders
 */

namespace Genesis\Builders;

interface BuilderInterface
{
    /**
     * Get the generated Builder output
     *
     * @return mixed
     */
    public function getOutput();

    /**
     * Tree-structured array representing the data structure
     *
     * @param array $structure
     *
     * @return mixed
     */
    public function populateNodes($structure);
}
