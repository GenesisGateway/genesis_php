<?php

namespace spec\Fixtures\Api\Stubs\Parser;

use Genesis\Api\Response;
use Genesis\Builder;
use Genesis\Parsers\Json;
use Genesis\Parsers\Xml;

/**
 * Class BaseStub
 * @package spec\Fixtures\Api\Stubs
 */
class ParserStub
{
    const ROOT                 = 'spec/Fixtures/Api';
    const MESSAGE_TYPE_PATTERN = '$|message_type|';

    /**
     * File Path
     *
     * @var string $file
     */
    private $file;

    /**
     * The object source
     *
     * @var string $path
     */
    private $path;

    /**
     * Parser Instance
     *
     * @var $parser
     */
    private $parser;

    public function __construct($path)
    {
        $this->path = self::ROOT . DIRECTORY_SEPARATOR .
            self::MESSAGE_TYPE_PATTERN . DIRECTORY_SEPARATOR .
            str_replace('\\', '/', $path);
    }

    /**
     * Dynamic Call of non existing method
     * Creating File Path for specific Request/Response
     *
     * @param $name
     * @param $arguments
     * @return $this
     */
    public function __call($name, $arguments)
    {
        if (!$this->validateArguments($arguments)) {
            return $this;
        }

        $this->path = str_replace(
            self::MESSAGE_TYPE_PATTERN,
            ucfirst(strtolower($arguments[1])),
            $this->path
        );

        $this->file = $this->path . DIRECTORY_SEPARATOR . $name . '.' . strtolower($arguments[0]);

        $this->loadParser($arguments[0], $arguments[1]);

        return $this;
    }

    private function loadParser($builder, $type)
    {
        if (strtolower($type) === 'response') {
            switch (strtolower($builder)) {
                case Builder::XML:
                    $this->parser = new Xml();
                    break;
                case Builder::JSON:
                    $this->parser = new Json();
                    break;
            }

            if (!is_null($this->parser)) {
                $this->parser->skipRootNode();
            }
        }
    }

    public function getParsedDocument()
    {
        if (is_null($this->parser)) {
            return '';
        }

        $this->parser->parseDocument(
            $this->getDocumentContent()
        );

        $responseObj = $this->parser->getObject();

        Response::transform([$responseObj]);

        return $responseObj;
    }

    protected function getDocumentContent()
    {
        return is_null($this->file) ? '' : file_get_contents($this->file);
    }

    private function validateArguments($arguments)
    {
        return (is_array($arguments) && count($arguments) >= 2);
    }
}
