<?php

namespace spec\SharedExamples\Genesis\Api;

use Genesis\Api\Constants\Errors;

/**
 * Trait ResponseErrorCodesExample
 *
 * @package spec\SharedExamples\Genesis\Api
 */
trait ResponseErrorCodesExample
{
    public function it_should_not_fail_with_error_status_code_110($network)
    {
        $this->testErrorStatus(110, $network);
    }

    public function it_should_not_fail_with_error_status_code_220($network)
    {
        $this->testErrorStatus(220, $network);
    }

    public function it_should_not_fail_with_error_status_code_340($network)
    {
        $this->testErrorStatus(340, $network);
    }

    public function it_should_not_fail_with_error_status_code_420($network)
    {
        $this->testErrorStatus(420, $network);
    }

    public function it_should_not_fail_with_error_status_code_510($network)
    {
        $this->testErrorStatus(510, $network);
    }

    public function it_should_not_fail_with_error_status_code_693($network)
    {
        $this->testErrorStatus(693, $network);
    }

    public function it_should_not_fail_with_error_status_code_730($network)
    {
        $this->testErrorStatus(730, $network);
    }

    public function it_should_not_fail_with_error_status_code_804($network)
    {
        $this->testErrorStatus(804, $network);
    }

    public function it_should_not_fail_with_error_status_code_910($network)
    {
        $this->testErrorStatus(910, $network);
    }

    public function it_should_not_fail_with_reconcile_error_code($network)
    {
        $sample = file_get_contents('spec/Fixtures/Api/Response/ReconcileErrorStatus.xml');

        $this->prepareNetworkMock($network, $sample);

        $this->shouldNotThrow()->during('parseResponse', array($network));

        $this->isSuccessful()->shouldBe(false);
        $this->getErrorDescription()->shouldBe(Errors::getErrorDescription(440));
    }

    protected function testErrorStatus($status, $network)
    {
        $sample = $this->prepareXmlResponse($status);

        $this->prepareNetworkMock($network, $sample);

        $this->shouldNotThrow()->during('parseResponse', array($network));

        $this->isSuccessful()->shouldBe(false);
        $this->getErrorDescription()->shouldBe(Errors::getErrorDescription($status));
    }

    /**
     * @param $status - the status code
     * @return string[] - the message and technical message in the response
     */
    protected function getTestErrorStatusData($status)
    {
        switch ($status) {
            case 110:
                $message   = '401 Unauthorized: Invalid Authentication!';
                $technical = 'Invalid Authentication';
                break;
            case 220:
                $message   = 'Transaction failed, please contact support!';
                $technical = 'Invalid Terminal';
                break;
            case 340:
                $message   = 'Please check input data for errors!';
                $technical = "'transaction_id' has already been used!";
                break;
            case 420:
                $message   = 'Something went wrong, please contact support!';
                $technical = 'acquirer does not support refund after authorize3d';
                break;
            case 510:
                $message   = 'Transaction declined';
                $technical = 'Credit card number is invalid';
                break;
            case 693:
                $message   = 'Transaction declined, please contact support!';
                $technical = 'IP address is not whitelisted, contact tech support!';
                break;
            case 730:
                $message   = 'Something went wrong, please contact support!';
                $technical = 'Consumer does not own this token';
                break;
            case 804:
                $message   = 'KYC Service provider Error';
                $technical = 'Authorization keys are invalid/missing.';
                break;
            case 910:
                $message   = 'Something went wrong, please contact support!';
                $technical = 'Card authentication failed';
                break;
        }

        return [$message, $technical];
    }

    /**
     * @param $status
     * @return string
     */
    private function prepareXmlResponse($status)
    {
        $sample = file_get_contents('spec/Fixtures/Api/Response/ErrorStatus.xml');

        list($message, $technical_message) = $this->getTestErrorStatusData($status);

        return str_replace(
            ['{{{status}}}', '{{{message}}}', '{{{technical_message}}}'],
            [$status, $message, $technical_message],
            $sample
        );
    }
}
