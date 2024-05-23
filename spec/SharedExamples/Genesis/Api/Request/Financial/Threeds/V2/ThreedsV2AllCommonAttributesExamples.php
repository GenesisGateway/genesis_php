<?php

namespace spec\SharedExamples\Genesis\Api\Request\Financial\Threeds\V2;

use spec\Genesis\Api\Stubs\Traits\Request\Financial\Threeds\V2\AllAttributesStub;

trait ThreedsV2AllCommonAttributesExamples
{
    public function it_should_return_correct_structure()
    {
        $this->getStructure()->shouldHaveKeyWithValue(
            'threeds_method',
            [
                'callback_url' => null
            ]
        );
        $this->getStructure()->shouldHaveKeyWithValue(
            'control',
            [
                'device_type'           => null,
                'challenge_window_size' => null,
                'challenge_indicator'   => null
            ]
        );
        $this->getStructure()->shouldHaveKeyWithValue(
            'purchase',
            [
                'category' => null
            ]
        );
        $this->getStructure()->shouldHaveKeyWithValue(
            'merchant_risk',
            [
                'shipping_indicator'           => null,
                'delivery_timeframe'           => null,
                'reorder_items_indicator'      => null,
                'pre_order_purchase_indicator' => null,
                'pre_order_date'               => null,
                'gift_card'                    => null,
                'gift_card_count'              => null
            ]
        );
        $this->getStructure()->shouldHaveKeyWithValue(
            'card_holder_account',
            [
                'creation_date'                       => null,
                'update_indicator'                    => null,
                'last_change_date'                    => null,
                'password_change_indicator'           => null,
                'password_change_date'                => null,
                'shipping_address_usage_indicator'    => null,
                'shipping_address_date_first_used'    => null,
                'transactions_activity_last_24_hours' => null,
                'transactions_activity_previous_year' => null,
                'provision_attempts_last_24_hours'    => null,
                'purchases_count_last_6_months'       => null,
                'suspicious_activity_indicator'       => null,
                'registration_indicator'              => null,
                'registration_date'                   => null
            ]
        );
        $this->getStructure()->shouldHaveKeyWithValue(
            'browser',
            [
                'accept_header'    => null,
                'java_enabled'     => null,
                'language'         => null,
                'color_depth'      => null,
                'screen_height'    => null,
                'screen_width'     => null,
                'time_zone_offset' => null,
                'user_agent'       => null
            ]
        );
        $this->getStructure()->shouldHaveKeyWithValue(
            'sdk',
            [
                'interface'                 => null,
                'ui_types'                  => [],
                'application_id'            => null,
                'encrypted_data'            => null,
                'ephemeral_public_key_pair' => null,
                'max_timeout'               => null,
                'reference_number'          => null
            ]
        );

        if ($this->getWrappedObject() instanceof AllAttributesStub) {
            $this->getStructure()->shouldHaveKeyWithValue(
                'recurring',
                [
                    'expiration_date' => null,
                    'frequency'       => null
                ]
            );
        }
    }
}
