<?php

namespace spec\Genesis\Network\Stubs\Traits;

/**
 * Mocked methods for Network adapters
 */
trait NetworkAdapter
{
    public $is_wpf = false;

    public $is_prod = false;

    public $is_billing_api = false;

    public $is_401_status = false;

    public $is_422_status = false;

    private function fetch_response()
    {
        if ($this->is_wpf) {
            return $this->wpfApi();
        }
        if ($this->is_billing_api) {
            return $this->billingApi();
        }

        if ($this->is_401_status) {
            return $this->statusError(401);
        }

        if ($this->is_422_status) {
            return $this->statusError(422);
        }

        return $this->transactionApi();
    }

    private function transactionApi()
    {
        $file = $this->is_prod ? 'ProdTransactionsApi' : 'StagingTransactionsApi';

        // Prevent actual request
        return str_replace(
            '|*DATE*|',
            date('Y-m-d H:i:s') . 'UTC',
            file_get_contents("{$this->fixtures_path}{$file}")
        );
    }

    private function wpfApi()
    {
        $file = $this->is_prod ? 'ProdWpfApi' : 'StagingWpfApi';

        // Prevent actual request
        return str_replace(
            '|*DATE*|',
            date('Y-m-d H:i:s') . 'UTC',
            file_get_contents("{$this->fixtures_path}{$file}")
        );
    }

    private function billingApi()
    {
        $file = $this->is_prod ? 'ProdBillingApi' : 'StagingBillingApi';

        // Prevent actual request
        return str_replace(
            '|*DATE*|',
            date('Y-m-d H:i:s') . 'UTC',
            file_get_contents("{$this->fixtures_path}{$file}")
        );
    }

    private function statusError($status)
    {
        $fixtures_path = 'spec/Fixtures/Api/Response/Network/ErrorStatuses/';

        switch ($status) {
            case 422:
                $file = $this->is_prod ? 'ProdError422' : 'StagingError422';
                break;
            default:
                $file = $this->is_prod ? 'ProdError401' : 'StagingError401';
        }

        // Prevent actual request
        return str_replace(
            '|*DATE*|',
            date('Y-m-d H:i:s') . 'UTC',
            file_get_contents("{$fixtures_path}{$file}")
        );
    }
}
