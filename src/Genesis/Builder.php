<?php
/*
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NON-INFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis;

/**
 * Builder handler
 *
 * @package    Genesis
 * @subpackage Builders
 */
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
     *
     * @param string $interface
     */
    public function __construct($interface = null)
    {
        $interface = $interface ?: \Genesis\Config::getInterface('builder');

        switch ($interface) {
            default:
            case 'xml':
                $this->context = new Builders\XML();
                break;
            case 'json':
                $this->context = new Builders\JSON();
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
