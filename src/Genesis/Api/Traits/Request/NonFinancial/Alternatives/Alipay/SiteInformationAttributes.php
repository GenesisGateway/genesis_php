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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Traits\Request\NonFinancial\Alternatives\Alipay;

use Genesis\Exceptions\InvalidArgument;
use Genesis\Utils\Common as CommonUtils;

/**
 * Trait SiteInformationAttributes
 *
 * Flat accessors for the Alipay Register Merchant `site_information` object.
 * Requires the RestrictedSetter trait (provided by Genesis\Api\Request).
 *
 * @package Genesis\Api\Traits\Request\NonFinancial\Alternatives\Alipay
 *
 * @see \Genesis\Api\Constants\NonFinancial\Alternatives\Alipay\SiteTypes
 *
 * @method string|null getSiteInformationType() Site type (SiteTypes::WEB or SiteTypes::APP)
 * @method $this setSiteInformationType($value) Site type (SiteTypes::WEB or SiteTypes::APP)
 * @method string|null getSiteInformationUrl() Site URL (website or app download URL)
 * @method string|null getSiteInformationName() Site name
 */
trait SiteInformationAttributes
{
    /**
     * Site type: WEB for a website URL, APP for an app download URL (uppercase only)
     *
     * @var string|null
     */
    protected $site_information_type;

    /**
     * Site URL, http/https, max 256 characters
     *
     * @var string|null
     */
    protected $site_information_url;

    /**
     * Site name, max 512 characters
     *
     * @var string|null
     */
    protected $site_information_name;

    /**
     * Sets the site URL. Empty input clears the field.
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setSiteInformationUrl($value)
    {
        if ($value === null || $value === '') {
            $this->site_information_url = null;

            return $this;
        }

        $value = (string) $value;

        if (!CommonUtils::isValidUrl($value) || !preg_match('/^https?:\/\//i', $value)) {
            throw new InvalidArgument(
                'Invalid value for site_information_url. A valid http or https URL is expected.'
            );
        }

        return $this->setLimitedString('site_information_url', $value, null, 256);
    }

    /**
     * Sets the site name. Empty input clears the field.
     *
     * @param string|null $value
     *
     * @return $this
     * @throws InvalidArgument
     */
    public function setSiteInformationName($value)
    {
        if ($value === null || $value === '') {
            $this->site_information_name = null;

            return $this;
        }

        return $this->setLimitedString('site_information_name', (string) $value, null, 512);
    }

    /**
     * Returns the site_information object structure
     *
     * @return array
     */
    protected function getSiteInformationStructure()
    {
        return [
            'type' => $this->site_information_type,
            'url'  => $this->site_information_url,
            'name' => $this->site_information_name,
        ];
    }
}
