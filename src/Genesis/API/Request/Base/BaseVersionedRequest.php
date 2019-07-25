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
namespace Genesis\API\Request\Base;

use Genesis\Builder;
use Genesis\Exceptions\InvalidArgument;

/**
 * Class BaseVersionedRequest
 *
 * @package Genesis\API\Request\Base
 */
abstract class BaseVersionedRequest extends \Genesis\API\Request
{
    const DEFAULT_VERSION = 'v1';

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $requestPath;

    /**
     * @var string
     */
    private $requestType;

    /**
     * @var array
     */
    private $allowedVersions;

    /**
     * BaseVersionedRequest constructor.
     *
     * @param $requestPath
     * @param string $requestType
     * @param array $allowedVersions
     */
    public function __construct($requestPath, $requestType = Builder::JSON, $allowedVersions = ['v1'])
    {
        $this->requestPath     = $requestPath;
        $this->requestType     = $requestType;
        $this->allowedVersions = $allowedVersions;
        $this->version         = static::DEFAULT_VERSION;

        parent::__construct($requestType);
    }

    /**
     * @param $version
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setVersion($version)
    {
        if (in_array($version, $this->allowedVersions)) {
            $this->version = $version;

            $this->initConfiguration();

            return $this;
        }

        throw new InvalidArgument(
            'Invalid API version, available versions are: ' . implode(', ', $this->allowedVersions)
        );
    }

    /**
     * @param $requestPath
     *
     * @return $this
     */
    public function setRequestPath($requestPath)
    {
        $this->requestPath = $requestPath;

        $this->initConfiguration();

        return $this;
    }

    /**
     * @param $requestType
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setRequestType($requestType)
    {
        switch ($requestType) {
            case Builder::XML:
            case Builder::JSON:
                $this->requestType = $requestType;

                return $this;
            default:
                throw new InvalidArgument('Invalid request type specified.');
        }
    }

    abstract protected function getRequestStructure();

    /**
     * Set the per-request configuration
     *
     * @return void
     */
    protected function initConfiguration()
    {
        switch ($this->requestType) {
            case Builder::XML:
                $this->initXmlConfiguration();
                break;
            case Builder::JSON:
                $this->initJsonConfiguration();
                break;
        }

        $this->initApiGatewayConfiguration($this->version . '/' . $this->requestPath, false);
    }

    /**
     * Create the request's Tree structure
     *
     * @return void
     */
    protected function populateStructure()
    {
        $this->treeStructure = \Genesis\Utils\Common::createArrayObject(
            $this->getRequestStructure()
        );
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getRequestPath()
    {
        return $this->requestPath;
    }

    /**
     * @return string
     */
    public function getRequestType()
    {
        return $this->requestType;
    }

    /**
     * @return array
     */
    public function getAllowedVersions()
    {
        return $this->allowedVersions;
    }
}
