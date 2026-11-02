<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial;

use Genesis\Api\Constants\Transaction\Parameters\Funding\IdentifierTypes;
use Genesis\Api\Constants\Transaction\Parameters\Payout\MoneyTransferPurposeOfPayment;
use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPayment;
use Genesis\Api\Constants\Transaction\Parameters\PurposeOfPaymentValues;
use Genesis\Exceptions\InvalidArgument;

/**
 * Shared Purpose of Payment examples (Properties 3 to 6) with their setup and XML helpers.
 *
 * The examples run in every consuming request spec. Request specs adapt them
 * through the protected hooks below: allowed, representative and rejected values, the root
 * XPath, the required-parameter and funding setups, and whether the request
 * supports funding attributes at all.
 */
trait PurposeOfPaymentAttributesExamples
{
    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 5: Purpose of payment renders once, at the request root
    public function it_should_render_purpose_of_payment_once_at_the_request_root()
    {
        // Purpose of payment alone does not render funding
        $this->setPurposeOfPaymentRequiredParameters();

        foreach ($this->getRepresentativePurposeOfPaymentValues() as $value) {
            $this->setPurposeOfPayment($value)->shouldReturn($this);
            $this->assertPurposeOfPaymentRendering($value, 0);
        }

        // Requests with funding render it as a root sibling
        if ($this->supportsPurposeOfPaymentFunding()) {
            $this->setPurposeOfPaymentFundingParameters();

            foreach ($this->getRepresentativePurposeOfPaymentValues() as $value) {
                $this->setPurposeOfPayment($value)->shouldReturn($this);
                $this->assertPurposeOfPaymentRendering($value, 1);
            }
        }

        // The last value set wins
        $values    = $this->getRepresentativePurposeOfPaymentValues();
        $lastValue = $values[count($values) - 1];

        $this->setPurposeOfPayment($values[0])->shouldReturn($this);
        $this->setPurposeOfPayment($lastValue)->shouldReturn($this);
        $this->assertPurposeOfPaymentPlacement($this->getPurposeOfPaymentXml(), $lastValue);
    }

    /**
     * Assert root placement of purpose_of_payment and the number of root funding elements.
     *
     * @param string $value
     * @param int $expectedFundingCount
     * @return void
     */
    private function assertPurposeOfPaymentRendering($value, $expectedFundingCount)
    {
        $xml = $this->getPurposeOfPaymentXml();
        $this->assertPurposeOfPaymentPlacement($xml, $value);

        if (
            count($xml->xpath($this->getPurposeOfPaymentFundingXpath())) !== $expectedFundingCount ||
            count($xml->xpath('//funding')) !== $expectedFundingCount
        ) {
            throw new \RuntimeException(
                sprintf(
                    'Expected %d funding element(s) as a root sibling of purpose_of_payment "%s".',
                    $expectedFundingCount,
                    $value
                )
            );
        }
    }

    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 6: Unset or null purpose of payment is omitted
    public function it_should_omit_unset_or_null_purpose_of_payment()
    {
        $this->setPurposeOfPaymentRequiredParameters();

        $this->getPurposeOfPayment()->shouldBe(null);
        $this->shouldNotThrow()->during('getDocument');
        $xml = $this->getPurposeOfPaymentXml();
        if ($this->getPurposeOfPaymentNodeCount($xml) !== 0 || count($xml->xpath('//funding')) !== 0) {
            throw new \RuntimeException('Purpose of payment or funding was rendered for the no-funding variant.');
        }

        $this->setPurposeOfPayment(PurposeOfPayment::ISBONU)->shouldReturn($this);
        $this->setPurposeOfPayment(null)->shouldReturn($this);

        $this->getPurposeOfPayment()->shouldBe(null);
        $this->shouldNotThrow()->during('getDocument');
        $xml = $this->getPurposeOfPaymentXml();
        if ($this->getPurposeOfPaymentNodeCount($xml) !== 0 || count($xml->xpath('//funding')) !== 0) {
            throw new \RuntimeException('Purpose of payment or funding was rendered for the no-funding variant.');
        }
    }

    // Feature: f2026082015-update_money_transfer_payout_and_purpose_of_payment, Property 4: Rejected purpose of payment values leave state unchanged
    public function it_should_reject_invalid_purpose_of_payment_values_without_changing_state()
    {
        $this->setPurposeOfPaymentRequiredParameters();

        $priorValue = PurposeOfPayment::ISBONU;

        $request = $this->getWrappedObject();

        foreach ($this->getRejectedPurposeOfPaymentValues() as $value) {
            foreach ([null, $priorValue] as $startValue) {
                $request->setPurposeOfPayment($startValue);
                $this->assertPurposeOfPaymentRejected($request, $value, $startValue);
            }
        }
    }

    /**
     * Assert the value is rejected and the previous state is preserved.
     *
     * @param object $request
     * @param mixed $value
     * @param string|null $startValue
     * @return void
     */
    private function assertPurposeOfPaymentRejected($request, $value, $startValue)
    {
        $label = sprintf(
            'purpose_of_payment %s (starting from %s)',
            json_encode($value),
            json_encode($startValue)
        );

        try {
            $request->setPurposeOfPayment($value);
        } catch (InvalidArgument $exception) {
            if ($request->getPurposeOfPayment() !== $startValue) {
                throw new \RuntimeException("Rejected $label changed the stored value.");
            }

            return;
        }

        throw new \RuntimeException("Expected InvalidArgument for $label.");
    }

    /**
     * Return the absolute XPath for the request's purpose_of_payment node.
     *
     * @return string
     */
    protected function getPurposeOfPaymentRootXpath()
    {
        return '/payment_transaction/purpose_of_payment';
    }

    /**
     * Set the request fields needed before generating its document.
     *
     * Request specs can override this when a shared property needs a setup
     * different from their regular required-parameter setup.
     *
     * @return void
     */
    protected function setPurposeOfPaymentRequiredParameters()
    {
        $this->setRequestParameters();
    }

    /**
     * Set the request fields and a fixed funding attribute for the funding variant.
     *
     * Only called when supportsPurposeOfPaymentFunding() returns true.
     *
     * @return void
     */
    protected function setPurposeOfPaymentFundingParameters()
    {
        $this->setPurposeOfPaymentRequiredParameters();
        $this->setFundingIdentifierType(IdentifierTypes::ACCOUNT_TO_ACCOUNT);
    }

    /**
     * Whether the request under test composes FundingAttributes.
     *
     * Requests without funding (Payout, Credit, RecurringSale) override this
     * hook to return false. Their funding example then asserts that no
     * funding element is rendered, instead of skipping the assertions.
     *
     * @return bool
     */
    protected function supportsPurposeOfPaymentFunding()
    {
        return true;
    }

    /**
     * Return the absolute XPath for the request's root-level funding node.
     *
     * @return string
     */
    protected function getPurposeOfPaymentFundingXpath()
    {
        return preg_replace('/purpose_of_payment$/', 'funding', $this->getPurposeOfPaymentRootXpath());
    }

    /**
     * Return the representative allowed values used for XML placement checks.
     *
     * One Visa code and one Visa human-readable value cover the input
     * categories of every request. Placement does not depend on the value, so
     * the full allow-list is checked only by the setter/getter example.
     * Payout overrides this hook to add a Mastercard-only value.
     *
     * @return array
     */
    protected function getRepresentativePurposeOfPaymentValues()
    {
        return [
            PurposeOfPayment::ISBONU,
            PurposeOfPaymentValues::BONUS_PAYMENT,
        ];
    }

    /**
     * Return representative invalid inputs rejected by every request.
     *
     * The strict setter itself is covered by RestrictedSetterSpec;
     * this set proves the request uses it.
     *
     * @return array
     */
    protected function getInvalidPurposeOfPaymentValues()
    {
        return [
            'INVALID',
            'isbonu',
            '',
            true,
        ];
    }

    /**
     * Return values that must be rejected by non-Payout requests.
     *
     * Payout overrides this hook, because it also accepts the Money Transfer values.
     *
     * @return array
     */
    protected function getRejectedPurposeOfPaymentValues()
    {
        return array_merge(
            $this->getInvalidPurposeOfPaymentValues(),
            [MoneyTransferPurposeOfPayment::FAMILY_SUPPORT]
        );
    }

    /**
     * Parse the generated request document.
     *
     * @return \SimpleXMLElement
     */
    protected function getPurposeOfPaymentXml()
    {
        return new \SimpleXMLElement($this->getWrappedObject()->getDocument());
    }

    /**
     * Return purpose_of_payment nodes at the request root.
     *
     * @param \SimpleXMLElement|null $xml
     * @return array
     */
    protected function getPurposeOfPaymentNodes($xml = null)
    {
        if ($xml === null) {
            $xml = $this->getPurposeOfPaymentXml();
        }

        return $xml->xpath($this->getPurposeOfPaymentRootXpath());
    }

    /**
     * Return the number of purpose_of_payment nodes at the request root.
     *
     * @param \SimpleXMLElement|null $xml
     * @return int
     */
    protected function getPurposeOfPaymentNodeCount($xml = null)
    {
        return count($this->getPurposeOfPaymentNodes($xml));
    }

    /**
     * Return the number of purpose_of_payment nodes nested under funding or money_transfer.
     *
     * @param \SimpleXMLElement $xml
     * @return int
     */
    protected function getPurposeOfPaymentNestedNodeCount($xml)
    {
        return count(array_merge(
            $xml->xpath('//funding//purpose_of_payment'),
            $xml->xpath('//money_transfer//purpose_of_payment')
        ));
    }

    /**
     * Assert root placement and uniqueness of purpose_of_payment.
     *
     * @param \SimpleXMLElement $xml
     * @param string $expectedValue
     * @return void
     */
    protected function assertPurposeOfPaymentPlacement($xml, $expectedValue)
    {
        if ($this->getPurposeOfPaymentNodeCount($xml) !== 1 ||
            $this->getPurposeOfPaymentNodeValues($xml) !== [$expectedValue] ||
            $this->getPurposeOfPaymentNestedNodeCount($xml) !== 0
        ) {
            throw new \RuntimeException(
                sprintf('Purpose of payment "%s" was rendered at an unexpected XML location.', $expectedValue)
            );
        }
    }

    /**
     * Return all purpose_of_payment values at the request root.
     *
     * @param \SimpleXMLElement|null $xml
     * @return array
     */
    protected function getPurposeOfPaymentNodeValues($xml = null)
    {
        $values = [];

        foreach ($this->getPurposeOfPaymentNodes($xml) as $node) {
            $values[] = (string) $node;
        }

        return $values;
    }
}
