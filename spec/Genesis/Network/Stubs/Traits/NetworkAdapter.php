<?php

namespace spec\Genesis\Network\Stubs\Traits;

/**
 * Mocked methods for Network adapters
 */
trait NetworkAdapter
{
    public $is_wpf = false;

    public $is_prod = false;

    private function fetch_response()
    {
        if ($this->is_wpf) {
            return $this->wpfApi();
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
}
