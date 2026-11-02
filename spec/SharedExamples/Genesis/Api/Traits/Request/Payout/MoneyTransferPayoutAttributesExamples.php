<?php

namespace spec\SharedExamples\Genesis\Api\Traits\Request\Payout;

use Genesis\Api\Constants\Transaction\Parameters\Payout\MoneyTransferSenderAccountNumberTypes;
use Genesis\Api\Constants\Transaction\Parameters\SourceOfFunds;
use Genesis\Api\Constants\Transaction\Parameters\Payout\MoneyTransferSourcesOfFunds;

/**
 * Shared setup and XML helpers for Money Transfer Payout examples.
 */
trait MoneyTransferPayoutAttributesExamples
{
    /**
     * Set fixed Payout and Money Transfer values required to generate a document.
     *
     * @return void
     */
    protected function setMoneyTransferPayoutRequiredParameters()
    {
        $this->setTransactionId('money-transfer-payout-001');
        $this->setUsage('Genesis PHP Client Automated Request');
        $this->setRemoteIp('192.0.2.1');
        $this->setAmount('100.00');
        $this->setCurrency('USD');
        $this->setCardHolder('John Doe');
        $this->setCardNumber('4200000000000000');
        $this->setExpirationMonth('12');
        $this->setExpirationYear('2030');
        $this->setCvv('123');
        $this->setBillingFirstName('John');
        $this->setBillingLastName('Doe');
        $this->setBillingAddress1('1 Main Street');
        $this->setBillingZipCode('10001');
        $this->setBillingCity('New York');
        $this->setBillingState('NY');
        $this->setBillingCountry('US');

        $this->setMoneyTransferType('person_to_person');
        $this->setMoneyTransferSenderAccountNumber('DE91100000000123456789');
        $this->setMoneyTransferSenderBirthDate('24-05-1990');
        $this->setMoneyTransferServiceProviderName('eMPPay');
        $this->setMoneyTransferSenderFirstName('John');
        $this->setMoneyTransferSenderLastName('Doe');
        $this->setMoneyTransferSenderCountry('US');
        $this->setMoneyTransferSenderCity('New York');
        $this->setMoneyTransferSenderZipCode('10001');
        $this->setMoneyTransferSenderAddress1('1 Main Street');
        $this->setMoneyTransferSenderState('NY');
        $this->setMoneyTransferReceiverFirstName('Jane');
        $this->setMoneyTransferReceiverLastName('Smith');
    }

    /**
     * Set fixed sender values while leaving receiver attributes unset.
     *
     * @return void
     */
    protected function setMoneyTransferSenderRequiredParameters()
    {
        $this->setMoneyTransferPayoutRequiredParameters();
        $this->setMoneyTransferReceiverFirstName(null);
        $this->setMoneyTransferReceiverLastName(null);
    }

    /**
     * Parse the generated Payout document.
     *
     * @return \SimpleXMLElement
     */
    protected function getMoneyTransferPayoutXml()
    {
        return new \SimpleXMLElement($this->getWrappedObject()->getDocument());
    }

    /**
     * Return the Money Transfer node from the generated Payout document.
     *
     * @param \SimpleXMLElement|null $xml
     * @return array
     */
    protected function getMoneyTransferNodes($xml = null)
    {
        if ($xml === null) {
            $xml = $this->getMoneyTransferPayoutXml();
        }

        return $xml->xpath('/payment_transaction/money_transfer');
    }

    /**
     * Return the receiver node from the generated Payout document.
     *
     * @param \SimpleXMLElement|null $xml
     * @return array
     */
    protected function getMoneyTransferReceiverNodes($xml = null)
    {
        if ($xml === null) {
            $xml = $this->getMoneyTransferPayoutXml();
        }

        return $xml->xpath('/payment_transaction/money_transfer/receiver');
    }

    /**
     * Return direct children of the Money Transfer node in document order.
     *
     * @param \SimpleXMLElement|null $xml
     * @return array
     */
    protected function getMoneyTransferChildNames($xml = null)
    {
        $nodes = $this->getMoneyTransferNodes($xml);

        if (count($nodes) === 0) {
            return [];
        }

        $names = [];
        foreach ($nodes[0]->children() as $child) {
            $names[] = $child->getName();
        }

        return $names;
    }

    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 7: Receiver block rendering mirrors the set attributes
    // Validates: Requirements 7.1, 7.2, 7.3, 7.4, 7.5, 10.6
    public function it_should_render_receiver_attributes_in_order_and_omit_cleared_values()
    {
        $this->setMoneyTransferSenderRequiredParameters();

        $this->assertMoneyTransferReceiverSetup([]);

        foreach ($this->getMoneyTransferReceiverSetups() as $expected) {
            // Never-set variant: per-field mapping and order from an empty receiver.
            $this->clearMoneyTransferReceiverAttributes(null);
            $this->setMoneyTransferReceiverSetup($expected);
            $this->assertMoneyTransferReceiverSetup($expected);

            // Cleared variant: clearing the other fields keeps the fields in the setup.
            $this->setMoneyTransferReceiverAllAttributes();
            $this->clearMoneyTransferReceiverAttributes(null, $expected);
            $this->assertMoneyTransferReceiverSetup($expected);
        }
    }

    /**
     * Return the receiver combinations covered by Property 7.
     *
     * @return array
     */
    protected function getMoneyTransferReceiverSetups()
    {
        return [
            [
                'first_name' => 'Jane',
                'last_name'  => 'Smith'
            ],
            [
                'first_name' => 'Jane',
                'last_name'  => 'Smith',
                'country'    => 'GB'
            ],
            [
                'first_name' => 'Jane',
                'last_name'  => 'Smith',
                'city'       => 'London'
            ],
            [
                'first_name' => 'Jane',
                'last_name'  => 'Smith',
                'state'      => 'LND'
            ],
            [
                'first_name' => 'Jane',
                'last_name'  => 'Smith',
                'zip_code'   => 'SW1A 1AA'
            ],
            [
                'first_name' => 'Jane',
                'last_name'  => 'Smith',
                'address1'   => '2 Market Street'
            ],
            // Full receiver in the API docs XML order (same as sender_address): state last.
            [
                'first_name' => 'Jane',
                'last_name'  => 'Smith',
                'country'    => 'GB',
                'city'       => 'London',
                'zip_code'   => 'SW1A 1AA',
                'address1'   => '2 Market Street',
                'state'      => 'LND'
            ]
        ];
    }

    /**
     * Apply one receiver setup using the public setters.
     *
     * @param array $expected
     * @return void
     */
    protected function setMoneyTransferReceiverSetup(array $expected)
    {
        $setters = $this->getMoneyTransferReceiverSetters();

        foreach ($expected as $field => $value) {
            $this->{$setters[$field]}($value)->shouldReturn($this);
        }
    }

    /**
     * Set every receiver attribute to fixed values.
     *
     * @return void
     */
    protected function setMoneyTransferReceiverAllAttributes()
    {
        $this->setMoneyTransferReceiverSetup([
            'first_name' => 'Jane',
            'last_name'  => 'Smith',
            'country'    => 'GB',
            'city'       => 'London',
            'state'      => 'LND',
            'zip_code'   => 'SW1A 1AA',
            'address1'   => '2 Market Street'
        ]);
    }

    /**
     * Clear receiver fields omitted from the expected setup.
     *
     * @param mixed $clearValue
     * @param array $expected
     * @return void
     */
    protected function clearMoneyTransferReceiverAttributes($clearValue, array $expected = [])
    {
        $setters = $this->getMoneyTransferReceiverSetters();

        foreach ($setters as $field => $setter) {
            if (!array_key_exists($field, $expected)) {
                $this->{$setter}($clearValue)->shouldReturn($this);
            }
        }
    }

    /**
     * Return receiver field to setter and getter metadata.
     *
     * @return array
     */
    protected function getMoneyTransferReceiverSetters()
    {
        return [
            'first_name' => 'setMoneyTransferReceiverFirstName',
            'last_name'  => 'setMoneyTransferReceiverLastName',
            'country'    => 'setMoneyTransferReceiverCountry',
            'city'       => 'setMoneyTransferReceiverCity',
            'state'      => 'setMoneyTransferReceiverState',
            'zip_code'   => 'setMoneyTransferReceiverZipCode',
            'address1'   => 'setMoneyTransferReceiverAddress1'
        ];
    }

    /**
     * Assert receiver getters, placement, child order and exact values.
     *
     * @param array $expected
     * @return void
     */
    protected function assertMoneyTransferReceiverSetup(array $expected)
    {
        $getters = [
            'first_name' => 'getMoneyTransferReceiverFirstName',
            'last_name'  => 'getMoneyTransferReceiverLastName',
            'country'    => 'getMoneyTransferReceiverCountry',
            'city'       => 'getMoneyTransferReceiverCity',
            'state'      => 'getMoneyTransferReceiverState',
            'zip_code'   => 'getMoneyTransferReceiverZipCode',
            'address1'   => 'getMoneyTransferReceiverAddress1'
        ];

        foreach ($getters as $field => $getter) {
            $this->{$getter}()->shouldBe(
                array_key_exists($field, $expected) ? $expected[$field] : null
            );
        }

        $xml = $this->getMoneyTransferPayoutXml();
        $receiverNodes = $this->getMoneyTransferReceiverNodes($xml);

        if (count($expected) === 0) {
            if (count($receiverNodes) !== 0) {
                throw new \RuntimeException('An empty receiver block was rendered.');
            }

            return;
        }

        if (count($receiverNodes) !== 1) {
            throw new \RuntimeException('The receiver block was not rendered exactly once.');
        }

        $children = [];
        $values = [];
        foreach ($receiverNodes[0]->children() as $child) {
            $children[] = $child->getName();
            $values[$child->getName()] = (string) $child;
        }

        if ($children !== array_keys($expected)) {
            throw new \RuntimeException('Receiver children were rendered in an unexpected order.');
        }

        foreach ($expected as $field => $value) {
            if (!isset($values[$field]) || $values[$field] !== $value) {
                throw new \RuntimeException('Receiver child value did not match the setter value.');
            }
        }

        $moneyTransferChildren = $this->getMoneyTransferChildNames($xml);
        if ($moneyTransferChildren[5] !== 'receiver' ||
            $moneyTransferChildren !== [
                'type',
                'sender_account_number',
                'sender_birth_date',
                'service_provider_name',
                'sender_address',
                'receiver'
            ]
        ) {
            throw new \RuntimeException('Receiver was not placed after sender_address.');
        }
    }

    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 8: Receiver length limits hold at the boundaries
    // Validates: Requirements 7.7, 7.8, 7.9, 7.10, 7.11, 7.12, 7.18, 10.7
    public function it_should_enforce_receiver_length_limits_at_boundaries()
    {
        $this->setMoneyTransferPayoutRequiredParameters();

        $limitedFields = [
            [
                'setter' => 'setMoneyTransferReceiverLastName',
                'getter' => 'getMoneyTransferReceiverLastName',
                'max'    => 30,
                'value'  => 'L'
            ],
            [
                'setter' => 'setMoneyTransferReceiverCity',
                'getter' => 'getMoneyTransferReceiverCity',
                'max'    => 15,
                'value'  => 'C'
            ],
            [
                'setter' => 'setMoneyTransferReceiverState',
                'getter' => 'getMoneyTransferReceiverState',
                'max'    => 3,
                'value'  => 'S'
            ],
            [
                'setter' => 'setMoneyTransferReceiverZipCode',
                'getter' => 'getMoneyTransferReceiverZipCode',
                'max'    => 10,
                'value'  => '1'
            ],
            [
                'setter' => 'setMoneyTransferReceiverAddress1',
                'getter' => 'getMoneyTransferReceiverAddress1',
                'max'    => 25,
                'value'  => 'A'
            ]
        ];

        foreach ($limitedFields as $field) {
            $priorValue = str_repeat($field['value'], $field['max']);
            $this->{$field['setter']}($priorValue)->shouldReturn($this);

            $this->{$field['setter']}(null)->shouldReturn($this);
            $this->{$field['getter']}()->shouldBe(null);

            $oneCharacter = str_repeat($field['value'], 1);
            $this->{$field['setter']}($oneCharacter)->shouldReturn($this);
            $this->{$field['getter']}()->shouldBe($oneCharacter);

            $maximum = str_repeat($field['value'], $field['max']);
            $this->{$field['setter']}($maximum)->shouldReturn($this);
            $this->{$field['getter']}()->shouldBe($maximum);

            $this->shouldThrow(\Genesis\Exceptions\InvalidArgument::class)->during(
                $field['setter'],
                [str_repeat($field['value'], $field['max'] + 1)]
            );
            $this->{$field['getter']}()->shouldBe($maximum);
        }

    }

    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 10: Receiver state is not required client-side
    // Validates: Requirements 7.13, 7.14, 10.8
    public function it_should_not_require_receiver_state_for_us_ca_other_or_unset_receiver_country()
    {
        $this->setMoneyTransferSenderRequiredParameters();

        // No country-specific state rule exists, so US, CA, one other country
        // and an unset country cover every equivalence class.
        foreach ([null, 'US', 'CA', 'BG'] as $country) {
            $this->setMoneyTransferReceiverFirstName('Jane');
            $this->setMoneyTransferReceiverLastName('Smith');
            $this->setMoneyTransferReceiverCountry($country);

            $this->setMoneyTransferReceiverState(null);
            $this->shouldNotThrow()->during('getDocument');

            $this->setMoneyTransferReceiverState('NY');
            $this->shouldNotThrow()->during('getDocument');
        }

        foreach (['US', 'CA'] as $country) {
            $this->setMoneyTransferReceiverCountry($country);
            $this->setMoneyTransferReceiverState(null);
            $this->setMoneyTransferReceiverFirstName('Jane');
            $this->setMoneyTransferReceiverLastName('Smith');

            $this->shouldNotThrow()->during('getDocument');
            $xml = $this->getMoneyTransferPayoutXml();
            if (
                count($xml->xpath('/payment_transaction/money_transfer/receiver/state')) !== 0 ||
                count($xml->xpath('/payment_transaction/money_transfer/receiver/country')) !== 1
            ) {
                throw new \RuntimeException('A US/CA receiver without state was not rendered as set.');
            }
        }
    }

    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 11: Receiver names are required whenever a receiver attribute is set
    // Validates: Requirements 7.15, 7.16, 7.17, 10.8, 10.12
    public function it_should_require_both_receiver_names_when_any_receiver_attribute_is_set()
    {
        $this->setMoneyTransferSenderRequiredParameters();
        $this->clearMoneyTransferReceiverAttributes(null);

        $receiverAttributes = [
            'first_name' => ['first_name' => 'Jane'],
            'last_name'  => ['last_name' => 'Smith'],
            'country'    => ['country' => 'GB'],
            'city'       => ['city' => 'London'],
            'state'      => ['state' => 'LND'],
            'zip_code'   => ['zip_code' => 'SW1A 1AA'],
            'address1'   => ['address1' => '2 Market Street'],
        ];

        foreach ($receiverAttributes as $setup) {
            $this->clearMoneyTransferReceiverAttributes(null);
            $this->setMoneyTransferReceiverSetup($setup);
            $this->shouldThrow(\Genesis\Exceptions\ErrorParameter::class)
                ->during('getDocument');
        }

        foreach (['country', 'city', 'state', 'zip_code', 'address1'] as $field) {
            $value = $receiverAttributes[$field][$field];

            $this->clearMoneyTransferReceiverAttributes(null);
            $this->setMoneyTransferReceiverSetup([
                'first_name' => 'Jane',
                $field       => $value,
            ]);
            $this->shouldThrow(\Genesis\Exceptions\ErrorParameter::class)
                ->during('getDocument');

            $this->clearMoneyTransferReceiverAttributes(null);
            $this->setMoneyTransferReceiverSetup([
                'last_name' => 'Smith',
                $field      => $value,
            ]);
            $this->shouldThrow(\Genesis\Exceptions\ErrorParameter::class)
                ->during('getDocument');
        }

        $this->clearMoneyTransferReceiverAttributes(null);
        $this->setMoneyTransferReceiverFirstName('Jane');
        $this->setMoneyTransferReceiverLastName('Smith');
        $this->shouldNotThrow()->during('getDocument');

        // The US/CA receiver name cases (with and without state) are covered by Property 10.
        $this->clearMoneyTransferReceiverAttributes(null);
        $this->setMoneyTransferReceiverSetup([
            'first_name' => 'Jane',
            'last_name'  => 'Smith',
            'country'    => 'US',
            'city'       => 'New York',
            'state'      => 'NY',
            'zip_code'   => '10001',
            'address1'   => '2 Market Street',
        ]);
        $this->shouldNotThrow()->during('getDocument');

        $this->clearMoneyTransferReceiverAttributes(null);
        $this->setMoneyTransferType(null);
        $this->shouldNotThrow()->during('getDocument');

        $this->setMoneyTransferType('person_to_person');
        $this->shouldNotThrow()->during('getDocument');
    }

    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 9: Receiver country validation
    // Validates: Requirements 7.6, 7.12, 10.6
    public function it_should_validate_receiver_country_codes_strictly()
    {
        $this->setMoneyTransferReceiverCountry('US')->shouldReturn($this);
        $this->getMoneyTransferReceiverCountry()->shouldBe('US');

        foreach ([
            'XX',
            'us',
            'USA',
            ' US',
            0,
            true,
        ] as $invalidCountry) {
            $this->shouldThrow(\Genesis\Exceptions\InvalidArgument::class)->during(
                'setMoneyTransferReceiverCountry',
                [$invalidCountry]
            );
            $this->getMoneyTransferReceiverCountry()->shouldBe('US');
        }

        $this->setMoneyTransferReceiverCountry(null)->shouldReturn($this);
        $this->getMoneyTransferReceiverCountry()->shouldBe(null);

        $this->setMoneyTransferReceiverCountry('GB')->shouldReturn($this);
        $this->setMoneyTransferReceiverCountry('')->shouldReturn($this);
        $this->getMoneyTransferReceiverCountry()->shouldBe(null);
    }

    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 13: Root and money transfer source of funds are independent
    // Validates: Requirements 8.8, 10.10
    public function it_should_render_root_and_money_transfer_sources_of_funds_independently()
    {
        $this->setMoneyTransferPayoutRequiredParameters();

        // Presence/absence combinations; enum validity is covered by Property 12.
        // Each value exists in one list only, so a swapped mapping is detected.
        $root = SourceOfFunds::OTHER_CREDIT_ACCOUNT;
        $moneyTransfer = MoneyTransferSourcesOfFunds::DEPOSIT_ACCOUNT;
        $combinations = [
            [null, null],
            [$root, null],
            [null, $moneyTransfer],
            [$root, $moneyTransfer],
        ];

        foreach ($combinations as $combination) {
            list($rootValue, $moneyTransferValue) = $combination;

            $this->setSourceOfFunds($rootValue)->shouldReturn($this);
            $this->setMoneyTransferSourceOfFunds($moneyTransferValue)->shouldReturn($this);

            $xml = $this->getMoneyTransferPayoutXml();
            $rootNodes = $xml->xpath('/payment_transaction/source_of_funds');
            $moneyTransferNodes = $xml->xpath(
                '/payment_transaction/money_transfer/source_of_funds'
            );

            if ($rootValue === null) {
                if (count($rootNodes) !== 0) {
                    throw new \RuntimeException(
                        'Unset root source of funds was rendered.'
                    );
                }
            } elseif (count($rootNodes) !== 1 || (string) $rootNodes[0] !== $rootValue) {
                throw new \RuntimeException(
                    'Root source of funds was not rendered independently.'
                );
            }

            if ($moneyTransferValue === null) {
                if (count($moneyTransferNodes) !== 0) {
                    throw new \RuntimeException(
                        'Unset money transfer source of funds was rendered.'
                    );
                }
            } elseif (count($moneyTransferNodes) !== 1 ||
                (string) $moneyTransferNodes[0] !== $moneyTransferValue
            ) {
                throw new \RuntimeException(
                    'Money transfer source of funds was not rendered independently.'
                );
            }
        }
    }

    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 12: Money transfer enum setters
    // Validates: Requirements 8.1, 8.2, 8.3, 8.4, 8.5, 8.6, 8.7, 8.9, 8.11, 10.9, 10.13
    public function it_should_validate_money_transfer_enum_setters_strictly()
    {
        $this->setMoneyTransferPayoutRequiredParameters();

        $enumFields = [
            [
                'values' => MoneyTransferSenderAccountNumberTypes::getAll(),
                'setter' => 'setMoneyTransferSenderAccountNumberType',
                'getter' => 'getMoneyTransferSenderAccountNumberType',
                'xml'    => 'sender_account_number_type',
            ],
            [
                'values' => MoneyTransferSourcesOfFunds::getAll(),
                'setter' => 'setMoneyTransferSourceOfFunds',
                'getter' => 'getMoneyTransferSourceOfFunds',
                'xml'    => 'source_of_funds',
            ],
        ];

        foreach ($enumFields as $field) {
            $priorValue = $field['values'][0];
            $this->{$field['setter']}($priorValue)->shouldReturn($this);
            $this->{$field['getter']}()->shouldBe($priorValue);

            $nodes = $this->getMoneyTransferPayoutXml()->xpath(
                '/payment_transaction/money_transfer/' . $field['xml']
            );
            if (count($nodes) !== 1 || (string) $nodes[0] !== $priorValue) {
                throw new \RuntimeException(
                    'Money transfer enum value was not rendered unchanged.'
                );
            }

            foreach (['invalid', '', 0, true, strtoupper($priorValue)] as $invalidValue) {
                $this->shouldThrow(\Genesis\Exceptions\InvalidArgument::class)->during(
                    $field['setter'],
                    [$invalidValue]
                );
                $this->{$field['getter']}()->shouldBe($priorValue);
            }

            $this->{$field['setter']}(null)->shouldReturn($this);
            $this->{$field['getter']}()->shouldBe(null);
            $nodes = $this->getMoneyTransferPayoutXml()->xpath(
                '/payment_transaction/money_transfer/' . $field['xml']
            );
            if (count($nodes) !== 0) {
                throw new \RuntimeException(
                    'Cleared money transfer enum value was rendered.'
                );
            }
        }

        $this->setMoneyTransferSenderAccountNumberType(null)->shouldReturn($this);
        $this->setMoneyTransferSourceOfFunds(null)->shouldReturn($this);
        $this->shouldNotThrow()->during('getDocument');
    }

    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 14: Legacy money transfer prefix is preserved
    // Validates: Requirements 8.10, 9.1, 9.2, 9.3, 10.11
    public function it_should_preserve_the_legacy_money_transfer_prefix_with_new_inputs()
    {
        $this->setMoneyTransferSenderRequiredParameters();

        $setups = [
            [],
            [
                'receiver' => [
                    'first_name' => 'Jane',
                    'last_name'  => 'Smith',
                    'country'    => 'GB',
                    'city'       => 'London',
                    'state'      => 'LND',
                    'zip_code'   => 'SW1A 1AA',
                    'address1'   => '2 Market Street'
                ]
            ],
            ['sender_account_number_type' => 'iban'],
            ['source_of_funds' => 'credit'],
            [
                'receiver' => [
                    'first_name' => 'Jane',
                    'last_name'  => 'Smith',
                    'country'    => 'GB',
                    'city'       => 'London',
                    'state'      => 'LND',
                    'zip_code'   => 'SW1A 1AA',
                    'address1'   => '2 Market Street'
                ],
                'sender_account_number_type' => 'iban',
                'source_of_funds'            => 'credit'
            ]
        ];

        foreach ($setups as $setup) {
            $this->setMoneyTransferReceiverAllAttributes();
            $this->setMoneyTransferSenderAccountNumberType(null);
            $this->setMoneyTransferSourceOfFunds(null);

            if (isset($setup['receiver'])) {
                $this->setMoneyTransferReceiverSetup($setup['receiver']);
            } else {
                $this->clearMoneyTransferReceiverAttributes(null);
            }

            if (isset($setup['sender_account_number_type'])) {
                $this->setMoneyTransferSenderAccountNumberType(
                    $setup['sender_account_number_type']
                );
            }

            if (isset($setup['source_of_funds'])) {
                $this->setMoneyTransferSourceOfFunds($setup['source_of_funds']);
            }

            $xml = $this->getMoneyTransferPayoutXml();
            $moneyTransferNodes = $this->getMoneyTransferNodes($xml);
            $children = [];
            $values = [];
            foreach ($moneyTransferNodes[0]->children() as $child) {
                $children[] = $child->getName();
                $values[$child->getName()] = (string) $child;
            }

            if (array_slice($children, 0, 5) !== [
                'type',
                'sender_account_number',
                'sender_birth_date',
                'service_provider_name',
                'sender_address'
            ] || array_intersect_key($values, array_flip([
                'type',
                'sender_account_number',
                'sender_birth_date',
                'service_provider_name'
            ])) !== [
                'type'                  => 'person_to_person',
                'sender_account_number' => 'DE91100000000123456789',
                'sender_birth_date'     => '24-05-1990',
                'service_provider_name' => 'eMPPay'
            ]) {
                throw new \RuntimeException('Legacy money transfer prefix changed.');
            }

            $senderAddress = $moneyTransferNodes[0]->sender_address;
            $senderChildren = [];
            $senderValues = [];
            foreach ($senderAddress->children() as $child) {
                $senderChildren[] = $child->getName();
                $senderValues[$child->getName()] = (string) $child;
            }

            if ($senderChildren !== [
                'first_name',
                'last_name',
                'country',
                'city',
                'zip_code',
                'address1',
                'state'
            ] || $senderValues !== [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'country'    => 'US',
                'city'       => 'New York',
                'zip_code'   => '10001',
                'address1'   => '1 Main Street',
                'state'      => 'NY'
            ]) {
                throw new \RuntimeException('Legacy sender address changed.');
            }
        }

        $requiredSenderFields = [
            'setMoneyTransferSenderAccountNumber',
            'setMoneyTransferSenderFirstName',
            'setMoneyTransferSenderLastName',
            'setMoneyTransferSenderCountry',
            'setMoneyTransferSenderCity',
            'setMoneyTransferSenderZipCode',
            'setMoneyTransferSenderAddress1'
        ];
        foreach ($requiredSenderFields as $setter) {
            $this->setMoneyTransferSenderRequiredParameters();
            $this->{$setter}(null);
            $this->shouldThrow(\Genesis\Exceptions\ErrorParameter::class)
                ->during('getDocument');
        }
    }
}
