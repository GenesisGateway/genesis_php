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

namespace Genesis\API\Traits\Request;

use Genesis\Exceptions\InvalidArgument;

/**
 * Trait DocumentAttributes
 * @package Genesis\API\Traits\Request
 */
trait DocumentAttributes
{
    /**
     * @var string
     */
    protected $document_id;

    /**
     * @return string
     */
    public function getDocumentIdRegex()
    {
        return '/^[A-Z]{5}[0-9]{4}[A-Z0-9]$/';
    }

    /**
     * @param $documentId
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setDocumentId($documentId)
    {
        if (preg_match($this->getDocumentIdRegex(), $documentId)) {
            $this->document_id = $documentId;

            return $this;
        }

        throw new InvalidArgument(
            'document_id must be a string with 10 alphanumeric letters.' .
                     '5 letters, followed by 4 numbers, followed by 1 letter or number. Example: ABCDE1234F'
        );
    }
}
