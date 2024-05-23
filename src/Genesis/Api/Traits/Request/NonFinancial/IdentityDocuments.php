<?php

/**
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
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2024 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\NonFinancial;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait IdentityDocuments
 * @package Genesis\Api\Traits\Request\NonFinancial
 */
trait IdentityDocuments
{
    /**
     * @var string
     */
    protected $doc_base64_content;

    /**
     * @var string
     */
    protected $doc_mime_type;

    /**
     * @var array
     */
    protected $docs = [];

    /**
     * @param $index int
     *
     * @return array
     */
    public function getDoc($index)
    {
        if (!isset($this->docs[$index])) {
            return null;
        }

        return $this->docs[$index];
    }

    /**
     * @param $base64Content
     * @param $mimeType
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function addDoc($base64Content, $mimeType)
    {
        $documentsCount = count($this->docs);

        switch ($documentsCount) {
            case 0:
                // These are used for the required fields check.
                $this->doc_base64_content = true;
                $this->doc_mime_type      = true;
                break;
            case 4:
                throw new InvalidArgument('Maximum number of 4 documents reached.');
        }

        $this->docs[] = [
            'base64_content' => $base64Content,
            'mime_type'      => $mimeType
        ];

        return $this;
    }

    /**
     * Removes all documents
     */
    public function clearDocs()
    {
        $this->doc_base64_content = null;
        $this->doc_mime_type      = null;
        $this->docs               = [];
    }
}
