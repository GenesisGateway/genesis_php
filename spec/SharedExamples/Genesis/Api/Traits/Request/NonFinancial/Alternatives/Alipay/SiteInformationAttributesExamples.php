<?php

namespace spec\SharedExamples\Genesis\Api\Traits\Request\NonFinancial\Alternatives\Alipay;

use Genesis\Api\Constants\NonFinancial\Alternatives\Alipay\SiteTypes;
use Genesis\Exceptions\InvalidArgument;

/**
 * Trait SiteInformationAttributesExamples
 *
 * Used as shared example to spec the Alipay site_information attributes.
 * Requires a JSON request and a setRequestParameters() helper in the spec class.
 *
 * @package spec\SharedExamples\Genesis\Api\Traits\Request\NonFinancial\Alternatives\Alipay
 */
trait SiteInformationAttributesExamples
{
    public function it_should_set_site_information_type_with_allowed_values()
    {
        foreach (SiteTypes::getAll() as $siteType) {
            $this->setSiteInformationType($siteType);
            $this->getSiteInformationType()->shouldBe($siteType);
        }
    }

    public function it_should_include_site_information_type_in_document()
    {
        foreach (SiteTypes::getAll() as $siteType) {
            $this->setRequestParameters();
            $this->setSiteInformationType($siteType);

            $this->getDocument()->shouldContain('"site_information":{"type":"' . $siteType . '"');
        }
    }

    public function it_should_accept_http_and_https_site_information_url()
    {
        $validUrls = [
            'http://example.com',
            'https://example.com',
            'HTTPS://example.com/path?query=1',
        ];

        foreach ($validUrls as $url) {
            $this->shouldNotThrow()->during('setSiteInformationUrl', [$url]);
            $this->getSiteInformationUrl()->shouldBe($url);
        }
    }

    public function it_should_clear_site_information_url_with_empty_values()
    {
        foreach ([null, ''] as $emptyValue) {
            $this->setSiteInformationUrl('https://example.com');
            $this->getSiteInformationUrl()->shouldNotBe(null);

            $this->setSiteInformationUrl($emptyValue)->shouldReturn($this->getWrappedObject());
            $this->getSiteInformationUrl()->shouldBe(null);
        }
    }

    public function it_should_fail_with_invalid_site_information_url()
    {
        $invalidUrls = [
            'example.com',
            'not a url',
            'ftp://example.com',
            'mailto:john@example.com',
        ];

        foreach ($invalidUrls as $url) {
            $this->shouldThrow(InvalidArgument::class)->during('setSiteInformationUrl', [$url]);
        }
    }

    public function it_should_accept_site_information_url_with_max_length()
    {
        $url = $this->buildSiteInformationUrl(256);

        $this->shouldNotThrow()->during('setSiteInformationUrl', [$url]);
        $this->getSiteInformationUrl()->shouldBe($url);
    }

    public function it_should_fail_with_site_information_url_exceeding_max_length()
    {
        $this->shouldThrow(new InvalidArgument('site_information_url value must be max 256 chars long.'))
            ->during('setSiteInformationUrl', [$this->buildSiteInformationUrl(257)]);
    }

    public function it_should_set_site_information_name()
    {
        $this->shouldNotThrow()->during('setSiteInformationName', ['My Shop Name']);
        $this->getSiteInformationName()->shouldBe('My Shop Name');
    }

    public function it_should_clear_site_information_name_with_empty_values()
    {
        foreach ([null, ''] as $emptyValue) {
            $this->setSiteInformationName('My Shop Name');
            $this->getSiteInformationName()->shouldNotBe(null);

            $this->setSiteInformationName($emptyValue)->shouldReturn($this->getWrappedObject());
            $this->getSiteInformationName()->shouldBe(null);
        }
    }

    public function it_should_accept_site_information_name_with_max_length()
    {
        $name = str_repeat('a', 512);

        $this->shouldNotThrow()->during('setSiteInformationName', [$name]);
        $this->getSiteInformationName()->shouldBe($name);
    }

    public function it_should_fail_with_site_information_name_exceeding_max_length()
    {
        $this->shouldThrow(new InvalidArgument('site_information_name value must be max 512 chars long.'))
            ->during('setSiteInformationName', [str_repeat('a', 513)]);
    }

    public function it_should_build_site_information_structure_in_document()
    {
        $this->setRequestParameters();
        $this->setSiteInformationType(SiteTypes::APP);
        $this->setSiteInformationUrl('https://example.com/app');
        $this->setSiteInformationName('My App');

        $expected = json_encode([
            'site_information' => [
                'type' => SiteTypes::APP,
                'url'  => 'https://example.com/app',
                'name' => 'My App',
            ],
        ]);

        // Strip the outer braces to match the key inside the full document
        $this->getDocument()->shouldContain(substr($expected, 1, -1));
    }

    /**
     * Builds a valid https URL of exactly $length characters (min 21)
     *
     * @param int $length
     *
     * @return string
     */
    protected function buildSiteInformationUrl($length)
    {
        $prefix = 'https://example.com/';

        return $prefix . str_repeat('a', $length - strlen($prefix));
    }
}
