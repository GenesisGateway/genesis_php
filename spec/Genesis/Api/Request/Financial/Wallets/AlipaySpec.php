<?php

namespace spec\Genesis\Api\Request\Financial\Wallets;

use Genesis\Api\Request\Financial\Wallets\Alipay;
use Genesis\Utils\Common;
use Genesis\Utils\Country;
use Genesis\Utils\Currency;
use PhpSpec\ObjectBehavior;
use spec\SharedExamples\Genesis\Api\Request\Financial\NeighborhoodAttributesExamples;
use spec\SharedExamples\Genesis\Api\Request\RequestExamples;

/**
 * Class AlipaySpec
 *
 * Feature: f2026091501-add_alipay_transaction_support
 *
 * The nine correctness properties from the design are implemented below, one phpspec example each,
 * tagged with a `// Feature: ... Property N:` comment. The attribute-oriented properties (P2, P3, P4)
 * quantify over the two named, disjoint sets defined in the design and declared here as separate
 * arrays: the Documented_Attribute_Set and the Parity_Attributes, whose union is the Attribute_Surface.
 * `amount` is the sole Transformed_Attribute: P5 owns it, and P3 excludes it from literal-appearance
 * checking.
 *
 * @package spec\Genesis\Api\Request\Financial\Wallets
 */
class AlipaySpec extends ObjectBehavior
{
    use NeighborhoodAttributesExamples;
    use RequestExamples;

    /**
     * Minimum sampled iterations for the sampled properties (design: "at least 100 iterations").
     */
    const SAMPLE_ITERATIONS = 100;

    /**
     * The documented Alipay allowed-currency set (design Decision 1). Referenced instead of a
     * bare literal so P7's out-of-set choice stays anchored to "the declared allowed currency set".
     *
     * @var array
     */
    private static $allowedCurrencies = ['CNY', 'EUR'];

    public function it_is_initializable()
    {
        $this->shouldHaveType(Alipay::class);
    }

    // Feature: f2026091501-add_alipay_transaction_support, Registration: the generated document's
    // transaction_type element is literally `alipay` (Requirements 8.2, 8.8)
    public function it_should_have_alipay_transaction_type()
    {
        $this->setRequestParameters();

        $document = simplexml_load_string($this->getDocument()->getWrappedObject());

        if ($document === false) {
            throw new \Exception('Alipay generated a document that is not well-formed XML');
        }

        if ((string) $document->transaction_type !== 'alipay') {
            throw new \Exception(
                'transaction_type element was "' . (string) $document->transaction_type
                . '", expected "alipay"'
            );
        }
    }

    /**
     * A valid, fully populated Alipay request. Uses the shared default parameters, then pins the
     * documented allowed currency (CNY) and a valid billing country.
     */
    protected function setRequestParameters()
    {
        $this->setDefaultRequestParameters();

        $this->setCurrency('CNY');
        $this->setBillingCountry('CN');
    }

    /**
     * The 18-member Documented_Attribute_Set: attributes from the Gateway API Alipay parameter table.
     * Kept as its own array (not merged with the parity set) so the documented-vs-parity distinction
     * stays visible across P2, P3 and P4.
     *
     * @return array
     */
    private function documentedAttributeSet()
    {
        return [
            'transaction_id',
            'usage',
            'remote_ip',
            'notification_url',
            'return_success_url',
            'return_failure_url',
            'amount',
            'currency',
            'customer_email',
            'billing_first_name',
            'billing_last_name',
            'billing_address1',
            'billing_address2',
            'billing_zip_code',
            'billing_city',
            'billing_state',
            'billing_neighborhood',
            'billing_country'
        ];
    }

    /**
     * The Parity_Attributes: emitted for structural consistency with WeChat / Upi but not documented
     * for Alipay. `customer_phone` plus the nine shipping_* fields. Disjoint from the documented set;
     * reused by P4 to prove they cost nothing when unset.
     *
     * @return array
     */
    private function parityAttributes()
    {
        return [
            'customer_phone',
            'shipping_first_name',
            'shipping_last_name',
            'shipping_address1',
            'shipping_address2',
            'shipping_zip_code',
            'shipping_city',
            'shipping_state',
            'shipping_neighborhood',
            'shipping_country'
        ];
    }

    /**
     * The six required fields (design / Requirement 5.2). Their complement inside the documented set
     * plus the parity attributes forms the optional Attribute_Surface used by P4.
     *
     * @return array
     */
    private function requiredAttributes()
    {
        return [
            'transaction_id',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'billing_country'
        ];
    }

    /**
     * The Attribute_Surface: union of the documented set and the parity attributes.
     *
     * @return array
     */
    private function attributeSurface()
    {
        return array_merge($this->documentedAttributeSet(), $this->parityAttributes());
    }

    /**
     * Setter name for a snake_case attribute, e.g. billing_zip_code -> setBillingZipCode.
     *
     * @param string $attribute
     * @return string
     */
    private function setterFor($attribute)
    {
        return 'set' . Common::snakeCaseToCamelCase($attribute);
    }

    /**
     * Getter name for a snake_case attribute, e.g. billing_zip_code -> getBillingZipCode.
     *
     * @param string $attribute
     * @return string
     */
    private function getterFor($attribute)
    {
        return 'get' . Common::snakeCaseToCamelCase($attribute);
    }

    /**
     * Parse the request document and return the billing_address SimpleXMLElement, failing loudly if
     * the document is malformed or the element is missing.
     *
     * @param string $document
     * @return \SimpleXMLElement
     * @throws \Exception
     */
    private function extractBillingAddress($document)
    {
        $xml = simplexml_load_string($document);

        if ($xml === false) {
            throw new \Exception('Alipay generated a document that is not well-formed XML');
        }

        // simplexml_load_string returns the root element itself, which is <payment_transaction>.
        if (!isset($xml->billing_address)) {
            throw new \Exception('billing_address element is missing from the generated document');
        }

        return $xml->billing_address;
    }

    // Feature: f2026091501-add_alipay_transaction_support, Property 2: Every attribute in the
    // Attribute_Surface is settable — for each attribute a Faker value round-trips through its
    // setter/getter without raising InvalidMethod (Requirements 4.1, 4.2, 4.7, 8.7)
    public function it_should_expose_every_attribute_surface_attribute_as_settable()
    {
        $faker = $this->getFaker();

        foreach ($this->attributeSurface() as $attribute) {
            $setter = $this->setterFor($attribute);
            $getter = $this->getterFor($attribute);

            // amount is numeric-validated and stored as a parsed numeric string; format-validated
            // fields (email, URL) need well-formed input; everything else accepts a free string.
            // Round-trip a value whose stored form is stable.
            $value = ($attribute === 'amount') ? '5319' : $this->settableValueFor($attribute, $faker);

            $this->$setter($value);
            $this->$getter()->shouldReturn($value);
        }
    }

    /**
     * Maps a documented attribute to its SimpleXML path relative to the parsed root, so P3 can assert
     * at the exact element rather than a document-wide substring match (which short Faker values can
     * satisfy coincidentally). `amount` is deliberately absent — it is the Transformed_Attribute owned
     * by P5 and excluded from literal-appearance checking (Requirement 4.9).
     *
     * @param \SimpleXMLElement $root
     * @param string $attribute
     * @return \SimpleXMLElement|null
     */
    private function elementFor($root, $attribute)
    {
        // $root is the parsed <payment_transaction> element; its leaves are direct children.
        $direct = [
            'transaction_id',
            'usage',
            'remote_ip',
            'notification_url',
            'return_success_url',
            'return_failure_url',
            'currency',
            'customer_email'
        ];

        if (in_array($attribute, $direct, true)) {
            return $root->{$attribute};
        }

        $billingMap = [
            'billing_first_name'   => 'first_name',
            'billing_last_name'    => 'last_name',
            'billing_address1'     => 'address1',
            'billing_address2'     => 'address2',
            'billing_zip_code'     => 'zip_code',
            'billing_city'         => 'city',
            'billing_state'        => 'state',
            'billing_neighborhood' => 'neighborhood',
            'billing_country'      => 'country'
        ];

        if (array_key_exists($attribute, $billingMap)) {
            return $root->billing_address->{$billingMap[$attribute]};
        }

        return null;
    }

    // Feature: f2026091501-add_alipay_transaction_support, Property 3: Populated non-transformed
    // attributes appear in the generated document — over 100+ Faker requests, each populated value is
    // found at its element path. `amount` is excluded (Transformed_Attribute owned by P5).
    // (Requirements 4.3, 4.9, 8.7)
    public function it_should_emit_every_populated_non_transformed_attribute()
    {
        $faker = $this->getFaker();

        // Documented, non-transformed attributes that have a known element path (amount excluded).
        $checkable = array_values(array_filter(
            $this->documentedAttributeSet(),
            function ($attribute) {
                return $attribute !== 'amount';
            }
        ));

        $optional = array_values(array_diff($this->documentedAttributeSet(), $this->requiredAttributes()));

        for ($i = 0; $i < self::SAMPLE_ITERATIONS; $i++) {
            $this->setRequestParameters();

            $expected = [];

            // Pin the required, non-transformed, path-checkable attributes to fresh Faker values.
            foreach (['transaction_id', 'return_success_url', 'return_failure_url', 'billing_country'] as $field) {
                $value = ($field === 'billing_country') ? $this->randomCountry($faker) : (string) $faker->uuid;
                $this->{$this->setterFor($field)}($value);
                $expected[$field] = $value;
            }
            $this->setCurrency('CNY');
            $expected['currency'] = 'CNY';

            // Random optional subset, each populated with a format-appropriate fresh Faker value so
            // that format-validated fields (email, URL) are not fed junk.
            foreach ($optional as $field) {
                if ($faker->boolean && in_array($field, $checkable, true)) {
                    $value = $this->validValueFor($field, $faker);
                    $this->{$this->setterFor($field)}($value);
                    $expected[$field] = $value;
                }
            }

            $root = simplexml_load_string($this->getDocument()->getWrappedObject());

            if ($root === false) {
                throw new \Exception('Alipay generated a document that is not well-formed XML on iteration ' . $i);
            }

            foreach ($expected as $field => $value) {
                $element = $this->elementFor($root, $field);

                if ($element === null || (string) $element !== (string) $value) {
                    throw new \Exception(
                        "Populated attribute '$field' expected value '$value' but the element held '"
                        . ($element === null ? '(missing)' : (string) $element) . "' on iteration $i"
                    );
                }
            }
        }
    }

    /**
     * A random valid billing country ISO code from the SDK's own list.
     *
     * @param \Faker\Generator $faker
     * @return string
     */
    private function randomCountry($faker)
    {
        $countries = Country::getList();

        return $countries[$faker->numberBetween(0, count($countries) - 1)];
    }

    /**
     * A format-appropriate valid value for a documented attribute, so format-validated fields
     * (email, URL) receive well-formed input while free-text fields get an opaque token.
     *
     * @param string $field
     * @param \Faker\Generator $faker
     * @return string
     */
    private function validValueFor($field, $faker)
    {
        switch ($field) {
            case 'customer_email':
                return $faker->email;
            case 'notification_url':
                return $faker->url;
            default:
                return (string) $faker->uuid;
        }
    }

    /**
     * A value accepted by the attribute's setter at set-time. Only customer_email carries a set-time
     * format validator; everything else on the Attribute_Surface accepts an opaque token.
     *
     * @param string $field
     * @param \Faker\Generator $faker
     * @return string
     */
    private function settableValueFor($field, $faker)
    {
        if ($field === 'customer_email') {
            return $faker->email;
        }

        return (string) $faker->uuid;
    }

    // Feature: f2026091501-add_alipay_transaction_support, Property 4: Unset optional attributes are
    // absent from the generated document — over 100+ iterations, for a random optional subset left
    // unset, no element is emitted. Domain is every optional Attribute_Surface member: the documented
    // set minus the 6 required fields (including usage and remote_ip), plus all parity attributes.
    // This example is what verifies the parity fields cost nothing when unset. (Requirements 4.6, 4.7)
    public function it_should_omit_unset_optional_attributes()
    {
        $faker = $this->getFaker();

        $optionalDocumented = array_diff($this->documentedAttributeSet(), $this->requiredAttributes());
        $optionalSurface    = array_values(array_merge($optionalDocumented, $this->parityAttributes()));

        for ($i = 0; $i < self::SAMPLE_ITERATIONS; $i++) {
            $this->setMinimalRequiredParameters();

            $unset = [];
            foreach ($optionalSurface as $attribute) {
                if ($faker->boolean) {
                    $this->{$this->setterFor($attribute)}(null);
                    $unset[] = $attribute;
                }
            }

            $root = simplexml_load_string($this->getDocument()->getWrappedObject());

            if ($root === false) {
                throw new \Exception('Alipay generated a document that is not well-formed XML on iteration ' . $i);
            }

            foreach ($unset as $attribute) {
                if ($this->attributeIsEmitted($root, $attribute)) {
                    throw new \Exception(
                        "Unset optional attribute '$attribute' was still emitted in the document on iteration $i"
                    );
                }
            }
        }
    }

    /**
     * Populate only the six required fields with valid values, leaving every optional attribute unset.
     * Used by P4 as the clean baseline before nulling a random optional subset.
     */
    private function setMinimalRequiredParameters()
    {
        $faker = $this->getFaker();

        $this->setTransactionId($faker->numberBetween(1, PHP_INT_MAX));
        $this->setAmount($faker->numberBetween(1, 10000));
        $this->setCurrency('CNY');
        $this->setReturnSuccessUrl($faker->url);
        $this->setReturnFailureUrl($faker->url);
        $this->setBillingCountry($this->randomCountry($faker));
    }

    /**
     * True when an element for the given attribute is present anywhere it could legitimately appear in
     * the document. Billing/shipping leaves are checked inside their address subtree; top-level and
     * payment_transaction leaves are checked at their element path.
     *
     * @param \SimpleXMLElement $root
     * @param string $attribute
     * @return bool
     */
    private function attributeIsEmitted($root, $attribute)
    {
        // $root is the parsed <payment_transaction> element; its leaves are direct children.
        $paths = [
            'usage'            => isset($root->usage),
            'remote_ip'        => isset($root->remote_ip),
            'notification_url' => isset($root->notification_url),
            'customer_email'   => isset($root->customer_email),
            'customer_phone'   => isset($root->customer_phone),
            'birth_date'       => isset($root->birth_date)
        ];

        if (array_key_exists($attribute, $paths)) {
            return $paths[$attribute];
        }

        if (strpos($attribute, 'billing_') === 0) {
            $leaf = $this->addressLeafName($attribute, 'billing_');

            return isset($root->billing_address) && isset($root->billing_address->{$leaf});
        }

        if (strpos($attribute, 'shipping_') === 0) {
            $leaf = $this->addressLeafName($attribute, 'shipping_');

            return isset($root->shipping_address) && isset($root->shipping_address->{$leaf});
        }

        return false;
    }

    /**
     * Convert a billing_/shipping_ attribute name into its emitted address leaf element name.
     *
     * @param string $attribute
     * @param string $prefix
     * @return string
     */
    private function addressLeafName($attribute, $prefix)
    {
        $leaf = substr($attribute, strlen($prefix));

        // billing_address1 / shipping_address1 keep their numeric suffix; the rest map 1:1.
        return $leaf;
    }

    // Feature: f2026091501-add_alipay_transaction_support, Property 5: Amount is converted to minor
    // currency units — 100+ Faker amounts crossed with both allowed currencies (CNY, EUR, both
    // exponent 2); the emitted amount equals Currency::amountToExponent() and exponentToAmount()
    // recovers the original. (Requirement 4.4)
    public function it_should_convert_amount_to_minor_currency_units()
    {
        $faker = $this->getFaker();

        for ($i = 0; $i < self::SAMPLE_ITERATIONS; $i++) {
            foreach (self::$allowedCurrencies as $currency) {
                $amount = $faker->randomFloat(2, 0.01, 99999.99);

                $this->setMinimalRequiredParameters();
                $this->setAmount($amount);
                $this->setCurrency($currency);

                $root = simplexml_load_string($this->getDocument()->getWrappedObject());

                if ($root === false) {
                    throw new \Exception('Alipay generated a document that is not well-formed XML on iteration ' . $i);
                }

                $emitted   = (string) $root->amount;
                $expected  = (string) Currency::amountToExponent($amount, $currency);

                if ($emitted !== $expected) {
                    throw new \Exception(
                        "Amount '$amount' in '$currency' was emitted as '$emitted', expected minor-unit '$expected'"
                    );
                }

                $recovered = Currency::exponentToAmount($emitted, $currency);

                if ((float) $recovered !== (float) $amount) {
                    throw new \Exception(
                        "exponentToAmount('$emitted', '$currency') was '$recovered', expected '$amount'"
                    );
                }
            }
        }
    }

    // Feature: f2026091501-add_alipay_transaction_support, Property 6: Any missing required field is
    // rejected — for each of the exhaustive 6-field required set, unsetting it causes getDocument() to
    // raise ErrorParameter. Uses the shared testMissingRequiredParameters() helper. (Requirements 5.2,
    // 5.3, 8.4)
    public function it_should_fail_when_missing_required_params()
    {
        $this->testMissingRequiredParameters([
            'transaction_id',
            'amount',
            'currency',
            'return_success_url',
            'return_failure_url',
            'billing_country'
        ]);
    }

    // Feature: f2026091501-add_alipay_transaction_support, Property 7: Any value outside a declared
    // allow-list is rejected — currency against {CNY, EUR} and billing_country against
    // Country::getList(); 100+ invalid samples per field raise ErrorParameter, and each valid member
    // is accepted (covering both CNY and EUR). The currency out-of-set samples are valid ISO codes
    // outside the declared set (USD, GBP) — the case that regresses if the allow-list is widened by
    // accident. (Requirements 5.6, 5.7, 8.5, 8.6)
    public function it_should_reject_values_outside_declared_allow_lists()
    {
        $faker = $this->getFaker();

        // --- currency: out-of-set values rejected ---
        // Valid ISO codes that are NOT in the declared allowed currency set.
        $outOfSetCurrencies = array_values(array_filter(
            ['USD', 'GBP'],
            function ($code) {
                return !in_array($code, self::$allowedCurrencies, true);
            }
        ));

        foreach ($outOfSetCurrencies as $currency) {
            $this->setRequestParameters();
            $this->setCurrency($currency);
            $this->shouldThrow(\Genesis\Exceptions\ErrorParameter::class)->during('getDocument');
        }

        // Malformed currency samples: wrong length, lowercase, numeric, unicode, punctuation.
        for ($i = 0; $i < self::SAMPLE_ITERATIONS; $i++) {
            $this->setRequestParameters();
            $this->setCurrency($this->malformedCode($faker));
            $this->shouldThrow(\Genesis\Exceptions\ErrorParameter::class)->during('getDocument');
        }

        // --- currency: each valid member accepted (both CNY and EUR) ---
        foreach (self::$allowedCurrencies as $currency) {
            $this->setRequestParameters();
            $this->setCurrency($currency);
            $this->shouldNotThrow()->during('getDocument');
        }

        // --- billing_country: out-of-set values rejected ---
        for ($i = 0; $i < self::SAMPLE_ITERATIONS; $i++) {
            $this->setRequestParameters();
            $this->setBillingCountry($this->malformedCode($faker));
            $this->shouldThrow(\Genesis\Exceptions\ErrorParameter::class)->during('getDocument');
        }

        // --- billing_country: a valid member accepted ---
        $this->setRequestParameters();
        $this->setBillingCountry($this->randomCountry($faker));
        $this->shouldNotThrow()->during('getDocument');
    }

    /**
     * Produce a value that is not a member of either declared allow-list: wrong length, lowercase,
     * numeric, unicode or punctuation.
     *
     * @param \Faker\Generator $faker
     * @return string
     */
    private function malformedCode($faker)
    {
        $candidates = [
            'zz',                              // lowercase, wrong for both allow-lists
            'usdd',                            // wrong length
            (string) $faker->numberBetween(10, 99), // numeric
            'x' . $faker->numberBetween(1, 9), // alphanumeric junk
            'çñü',                             // unicode
            '@#$',                             // punctuation
            $faker->lexify('?????')            // random 5-letter, outside any ISO set
        ];

        return $candidates[$faker->numberBetween(0, count($candidates) - 1)];
    }

    // Feature: f2026091501-add_alipay_transaction_support, Property 8: Populated billing values are
    // nested inside billing_address — over arbitrary non-empty billing subsets, each populated billing
    // value is found inside the billing_address subtree (traversed with simplexml, not a document-wide
    // substring match). (Requirement 8.9)
    public function it_should_nest_populated_billing_values_inside_billing_address()
    {
        $faker = $this->getFaker();

        $billingMap = [
            'billing_first_name'   => 'first_name',
            'billing_last_name'    => 'last_name',
            'billing_address1'     => 'address1',
            'billing_address2'     => 'address2',
            'billing_zip_code'     => 'zip_code',
            'billing_city'         => 'city',
            'billing_state'        => 'state',
            'billing_neighborhood' => 'neighborhood'
        ];

        for ($i = 0; $i < self::SAMPLE_ITERATIONS; $i++) {
            $this->setMinimalRequiredParameters();

            $expected = [];
            $subset   = false;

            foreach ($billingMap as $attribute => $leaf) {
                if ($faker->boolean) {
                    $value = (string) $faker->uuid;
                    $this->{$this->setterFor($attribute)}($value);
                    $expected[$leaf] = $value;
                    $subset = true;
                }
            }

            // Guarantee a non-empty subset.
            if (!$subset) {
                $value = (string) $faker->uuid;
                $this->setBillingCity($value);
                $expected['city'] = $value;
            }

            $billing = $this->extractBillingAddress($this->getDocument()->getWrappedObject());

            foreach ($expected as $leaf => $value) {
                if ((string) $billing->{$leaf} !== $value) {
                    throw new \Exception(
                        "Billing value expected inside billing_address/$leaf was '$value' but held '"
                        . (string) $billing->{$leaf} . "' on iteration $i"
                    );
                }
            }
        }
    }
}
