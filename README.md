Genesis PHP
===========

[![Latest Stable Version](https://poser.pugx.org/genesisgateway/genesis_php/v/stable)](https://packagist.org/packages/genesisgateway/genesis_php)
[![Total Downloads](https://img.shields.io/packagist/dt/GenesisGateway/genesis_php.svg?style=flat)](https://packagist.org/packages/GenesisGateway/genesis_php)
[![Software License](https://img.shields.io/badge/license-MIT-green.svg?style=flat)](LICENSE)

Overview
--------

Client Library for processing payments through Genesis Payment Processing Gateway. It's highly recommended to check out "Genesis Payment Gateway API Documentation" first, in order to get an overview of Genesis's Payment Gateway API and functionality.

Requirements
------------

* PHP version 5.5.9 or newer
* PHP Extensions:
    * [BCMath](https://php.net/bcmath)
    * [CURL](https://php.net/curl) (required, only if you use the curl network interface)
    * [Filter](https://php.net/filter)
    * [Hash](https://php.net/hash)
    * [XMLReader](https://php.net/xmlreader)
    * [XMLWriter](https://php.net/xmlwriter)
    * [JSON](https://www.php.net/manual/en/book.json)
    * [OpenSSL](https://www.php.net/manual/en/book.openssl.php)
* Composer (optional)

Note: Most of the extension are part of PHP and enabled by default, however some distributions are using custom configuration that might have some of them removed/disabled.

Installation
------------

#### Composer

```sh
composer.phar require genesisgateway/genesis_php
```

Note: If you want to use the package with PHP version lover than 7.4, you can use 

```sh
composer.phar require genesisgateway/genesis_php --update-no-dev
```

#### Manual
* Clone / [download](https://github.com/GenesisGateway/genesis_php/archive/master.zip) this repo

```sh
git clone http://github.com/GenesisGateway/genesis_php genesis_php && cd genesis_php
```

Getting Started
------------------

### Configuration

A sample configuration file settings_sample.ini is provided. The configuration file can be loaded via:
```php
\Genesis\Config::loadSettings('/path/to/config.ini');
```
Or the configuration settings can be set manually:
```php
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');
\Genesis\Config::setToken('<enter_your_token>');
```

```php
# Supported values: sandbox or production
environment         = sandbox

# Supported values: test, testing, staging or live, prod, production
endpoint            = ENTER_YOUR_ENDPOINT

# Credentials
username            = ENTER_YOUR_USERNAME
password            = ENTER_YOUR_PASSWORD

# Optional for WPF requests
token               = ENTER_YOUR_TOKEN

# Smart Router endpoint for Financial Transactions
# Doesn't require token
force_smart_routing = off

# Optional token for Billing Transactions API requests
billing_api_token   = ENTER_YOUR_TOKEN

[Interfaces]
# Supported values: curl or stream
network             = curl
```

### Transactions

```php
<?php
require 'vendor/autoload.php';

try {
// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');

// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');
\Genesis\Config::setToken('<enter_your_token>');

// Create a new Genesis instance with desired API request
$genesis = new \Genesis\Genesis('Financial\Cards\Authorize');

// Set request parameters
$genesis
    ->request()
        ->setTransactionId('43671')
        ->setUsage('40208 concert tickets')
        ->setRemoteIp('245.253.2.12')
        ->setAmount('50')
        ->setCurrency('USD')

        // Customer Details
        ->setCustomerEmail('travis@example.com')
        ->setCustomerPhone('1987987987987')

        // Credit Card Details
        ->setCardHolder('Travis Pastrana')
        ->setCardNumber('4200000000000000')
        ->setExpirationMonth('01')
        ->setExpirationYear('2020')
        ->setCvv('123')

        // Billing/Invoice Details
        ->setBillingFirstName('Travis')
        ->setBillingLastName('Pastrana')
        ->setBillingAddress1('Muster Str. 12')
        ->setBillingZipCode('10178')
        ->setBillingCity('Los Angeles')
        ->setBillingState('CA')
        ->setBillingCountry('US');

    // Send the request
    $genesis->execute();

    // Successfully completed the transaction - display the gateway unique id
    echo $genesis->response()->getResponseObject()->unique_id;

    // If there is an error - display the error information
    if (!$genesis->response()->isSuccessful()) {
        echo "Error code: {$genesis->response()->getResponseObject()->code}\n";
        echo "Message: {$genesis->response()->getResponseObject()->message}\n";
        echo "Technical message: {$genesis->response()->getResponseObject()->technical_message}\n";
    }
}
// Log/handle invalid parameters
// Example: Empty (required) parameter
catch (\Genesis\Exceptions\ErrorParameter $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle invalid arguments
// Example: invalid value given for accessor
catch (\Genesis\Exceptions\InvalidArgument $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
catch (\Genesis\Exceptions\ErrorNetwork $network) {
    error_log($network->getMessage());
}
// Upon invalid accessor is used
catch (\Genesis\Exceptions\InvalidMethod $error) {
    error_log($error->getMessage());
}

?>
```

Note: the file ```vendor/autoload.php``` is located inside the directory where you cloned the repo and it is auto-generated by [Composer]. If the file is missing, just run ```php composer.phar update``` inside the root directory

### Web Payment Form

```php
<?php
require 'vendor/autoload.php';

try {
// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');

// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');

// Create a new Genesis instance with Web Payment Form transaction request
/** @var \Genesis\Genesis $genesis */
$genesis = new Genesis('Wpf\Create');

// Assign $request variable. In some editors, auto-completion will guide you with the request building
/** @var \Genesis\Api\Request\Wpf\Create $request */
$request = $genesis->request();

// Set request parameters
$request
    ->setTransactionId('43671')
    ->setUsage('40208 concert tickets')
    ->setDescription('You are buying concert tickets!')
    ->setAmount('50')
    ->setCurrency('USD')

    // Notification parameters
    ->setNotificationUrl('https://www.example.com/notification')

    // Asynchronous parameters
    ->setReturnSuccessUrl('http://www.example.com/success')
    ->setReturnFailureUrl('http://www.example.com/failure')
    ->setReturnCancelUrl('http://www.example.com/cancel')
    ->setReturnPendingUrl('http://www.example.com/pending')

    // Customer Details
    ->setCustomerEmail('travis@example.com')
    ->setCustomerPhone('1987987987987')

    // Billing/Invoice Details
    ->setBillingFirstName('Travis')
    ->setBillingLastName('Pastrana')
    ->setBillingAddress1('Muster Str. 12')
    ->setBillingZipCode('10178')
    ->setBillingCity('Los Angeles')
    ->setBillingState('CA')
    ->setBillingCountry('US')

    // Web Payment Form language, default is EN if no language is provided
    ->setLanguage(\Genesis\Api\Constants\i18n::EN)

    // Set the Web Payment Form time to live, default value 30 minutes if no value is provided
    ->setLifetime(30)

    // Transaction Type without Custom Attribute
    ->addTransactionType(\Genesis\Api\Constants\Transaction\Types::SALE_3D)
    ->addTransactionType(\Genesis\Api\Constants\Transaction\Types::AUTHORIZE_3D)

    // Transaction Type with Custom Attribute
    ->addTransactionType(\Genesis\Api\Constants\Transaction\Types::PAYSAFECARD, ['customer_id' => '123456']);

    // Send the request
    $genesis->execute();

    // Successfully completed the transaction - redirect the customer to the provided URL
    echo $genesis->response()->getResponseObject()->redirect_url;

    // If there is an error - display the error information
    if (!$genesis->response()->isSuccessful()) {
        echo "Error code: {$genesis->response()->getResponseObject()->code}\n";
        echo "Message: {$genesis->response()->getResponseObject()->message}\n";
        echo "Technical message: {$genesis->response()->getResponseObject()->technical_message}\n";
    }
}
// Log/handle invalid parameters
// Example: Empty (required) parameter
catch (\Genesis\Exceptions\ErrorParameter $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle invalid arguments
// Example: invalid value given for accessor
catch (\Genesis\Exceptions\InvalidArgument $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
catch (\Genesis\Exceptions\ErrorNetwork $network) {
    error_log($network->getMessage());
}
// Upon invalid accessor is used
catch (\Genesis\Exceptions\InvalidMethod $error) {
    error_log($error->getMessage());
}

?>
```

Full list with the available Custom Attributes for every Transaction Type can be found [here](https://emerchantpay.github.io/gateway-api-docs/#wpf-transaction-types).

### Response

After Request execution (`$genesis->execute()`) a Response object can be accessed `$genesis->response()`.

The Response contains the original response from the Gateway:
```php
$genesis->response()->getResponseRaw()
```

The Response contains the parsed response from the Gateway:
```php
$genesis->response()->getResponseObject()
```

The HTTP response status code of the request is also available:
```php
$genesis->response()->getResponseCode()
```

A request that reached the Genesis payment gateway successfully can have an error status if there was a problem during the transaction execution i.e. the HTTP response status code was 200 but the transaction was declined/unsuccessful. In this case the Response will contain the payment gateway internal error `code`, additional `message` and more detailed `technical_message`. 
The full list of the possible error codes can be found [here](https://emerchantpay.github.io/gateway-api-docs/?php#error-codes-tables).

#### Transaction states

There are predefined checks for validating the status of the received response. Every available status received from the Genesis gateway can be checked in the following way:
```php
if ($genesis->response()->isNew())...
...
$genesis->response()->isApproved()
$genesis->response()->isDeclined()
$genesis->response()->isError()
$genesis->response()->isPendingAsync()
...
```
*Check [Transactions API States](https://emerchantpay.github.io/gateway-api-docs/?php#transaction-states) and [Web Payment Form States](https://emerchantpay.github.io/gateway-api-docs/?php#wpf-states) for more information about the possible transaction states.*

Smart Router
-------------

The Smart Routing API is a higher-level abstraction that allows for simpler and more efficient gateway Processing API integration.
It does not require the terminal token. This by itself minimizes the need for complex customer-level manual routing to terminals set up on the gateway platform configuration layer.

By default the Smart Router is disabled. Contact your account manager to use the functionality.

Smart Router global definition for all requests
 * PHP Config File
   ```php
   \Genesis\Config::setForceSmartRouting(true);
   ```
 * Ini Config File
   ```ini
   [Genesis]
   force_smart_routing = on
   ```

Smart Router definition per request
```php
$genesis->request()->setUseSmartRouter(true);
```

Example 3DSv2 Request
-------------
Sample request including all the conditionally required/optional params for initiating a 3DS transaction with the 3DSv2-Method authentication protocol.

Also, an example is provided for the 3DS-Method-continue API call that will have to be submitted after the 3DS-Method is initiated.
<details>

```php
<?php
require 'vendor/autoload.php';

// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');

// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');
\Genesis\Config::setToken('<enter_your_token>');

try {   
    // Create a new Genesis instance with desired API request
    $genesis = new \Genesis\Genesis('Financial\Cards\Sale3D');
    
    /** @var \Genesis\Api\Request\Financial\Cards\Sale3D $sale_3ds_v2_request */
    $sale_3ds_v2_request = $genesis->request();
    
    // Set request parameters
    $sale_3ds_v2_request
        ->setTransactionId('43671')
        ->setUsage('40208 concert tickets')
        ->setRemoteIp('245.253.2.12')
        ->setAmount('50')
        ->setCurrency('USD')
        // Return URLS
        ->setNotificationUrl('https://example.com/notification')
        ->setReturnSuccessUrl('https://example.com/return?type=success')
        ->setReturnFailureUrl('https://example.com/return?type=cancel')
        // Customer Details
        ->setCustomerEmail('john@example.com')
        ->setCustomerPhone('1987987987987')
        // Credit Card Details
        ->setCardHolder('FirstName LastName')

        // Test Cases
        ->setCardNumber('4012000000060085') // Test Case: Synchronous 3DSv2 Request with Frictionless flow
        //->setCardNumber('4066330000000004') // Test Case: Asynchronous 3DSv2 Request with 3DS-Method and Frictionless flow
        //->setCardNumber('4918190000000002') // Test Case: Asynchronous 3DSv2 Request with Challenge flow
        //->setCardNumber('4938730000000001') // Test Case: Asynchronous 3DSv2 Request with 3DS-Method Challenge flow
        //->setCardNumber('4901170000000003') // Test Case: Asynchronous 3DSv2 Request with Fallback flow
        //->setCardNumber('4901164281364345') // Test Case: Asynchronous 3DSv2 Request with 3DS-Method Fallback flow
        
        ->setExpirationMonth('01')
        ->setExpirationYear('2020')
        ->setCvv('123')
        // Billing/Invoice Details
        ->setBillingFirstName('John')
        ->setBillingLastName('Smith')
        ->setBillingAddress1('Muster Str. 12')
        ->setBillingZipCode('10178')
        ->setBillingCity('Los Angeles')
        ->setBillingState('CA')
        ->setBillingCountry('US')

        // 3DSv2 params

        // 3DSv2 Method Attributes
        ->setThreedsV2MethodCallbackUrl('https://www.example.com/threeds/threeds_method/callback')
        
        // 3DSv2 Control Attributes
        ->setThreedsV2ControlDeviceType(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control\DeviceTypes::BROWSER)
        ->setThreedsV2ControlChallengeWindowSize(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeWindowSizes::FULLSCREEN)
        ->setThreedsV2ControlChallengeIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeIndicators::PREFERENCE)
        
        // 3DSv2 Purchase Attributes
        ->setThreedsV2PurchaseCategory(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Purchase\Categories::SERVICE)
        
        // 3DSv2 Merchant Risk Attributes
        ->setThreedsV2MerchantRiskShippingIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\ShippingIndicators::VERIFIED_ADDRESS)
        ->setThreedsV2MerchantRiskDeliveryTimeframe(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\DeliveryTimeframes::ELECTRONICS)
        ->setThreedsV2MerchantRiskReorderItemsIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\ReorderItemIndicators::REORDERED)
        ->setThreedsV2MerchantRiskPreOrderPurchaseIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\PreOrderPurchaseIndicators::MERCHANDISE_AVAILABLE)
        ->setThreedsV2MerchantRiskPreOrderDate('31-12-2030')
        ->setThreedsV2MerchantRiskGiftCard(true) // Boolean attribute. Accepts values like `on`, `off`, `yes`, `no`, `true`, `false`, etc...
        ->setThreedsV2MerchantRiskGiftCardCount(99)
        
        // 3DSv2 Cardholder Account Attributes
        ->setThreedsV2CardHolderAccountCreationDate('31-12-2019')
        ->setThreedsV2CardHolderAccountUpdateIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\UpdateIndicators::FROM_30_TO_60_DAYS)
        ->setThreedsV2CardHolderAccountLastChangeDate('31-12-2019')
        ->setThreedsV2CardHolderAccountPasswordChangeIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\PasswordChangeIndicators::NO_CHANGE)
        ->setThreedsV2CardHolderAccountPasswordChangeDate('31-12-2019')
        ->setThreedsV2CardHolderAccountShippingAddressUsageIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\ShippingAddressUsageIndicators::CURRENT_TRANSACTION)
        ->setThreedsV2CardHolderAccountShippingAddressDateFirstUsed('31-12-2019')
        ->setThreedsV2CardHolderAccountTransactionsActivityLast24Hours(2)
        ->setThreedsV2CardHolderAccountTransactionsActivityPreviousYear(10)
        ->setThreedsV2CardHolderAccountProvisionAttemptsLast24Hours(1)
        ->setThreedsV2CardHolderAccountPurchasesCountLast6Months(5)
        ->setThreedsV2CardHolderAccountSuspiciousActivityIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\SuspiciousActivityIndicators::NO_SUSPICIOUS_OBSERVED)
        ->setThreedsV2CardHolderAccountRegistrationIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\RegistrationIndicators::FROM_30_TO_60_DAYS)
        ->setThreedsV2CardHolderAccountRegistrationDate('31-12-2019')
        
        // 3DSv2 Browser Attributes
        ->setThreedsV2BrowserAcceptHeader('*/*') // Exact content of the HTTP accept headers as sent to the 3DS Requester from the Cardholder browser
        ->setThreedsV2BrowserJavaEnabled(false) // Boolean attribute. Accepts values like `on`, `off`, `yes`, `no`, `true`, `false`, etc...
        ->setThreedsV2BrowserLanguage('en-GB')
        ->setThreedsV2BrowserColorDepth(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Browser\ColorDepths::BITS_32)
        ->setThreedsV2BrowserScreenHeight(900)
        ->setThreedsV2BrowserScreenWidth(1440)
        ->setThreedsV2BrowserTimeZoneOffset(-120)
        ->setThreedsV2BrowserUserAgent('Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36')
        
        // 3DSv2 SDK Attributes
        ->setThreedsV2SdkInterface(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk\Interfaces::NATIVE)
        ->setThreedsV2SdkUiTypes( // Also accepts a single string value ->setThreedsV2SdkUiTypes('text')
            [
                \Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk\UiTypes::SINGLE_SELECT,
                \Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk\UiTypes::MULTI_SELECT,
                \Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Sdk\UiTypes::TEXT
            ]
        )
        ->setThreedsV2SdkApplicationId('fc1650c0-5778-0138-8205-2cbc32a32d65')
        ->setThreedsV2SdkEncryptedData('encrypted-data-here')
        ->setThreedsV2SdkEphemeralPublicKeyPair('public-key-pair')
        ->setThreedsV2SdkMaxTimeout(10)
        ->setThreedsV2SdkReferenceNumber('sdk-reference-number-her');
        
        // 3DSv2 Recurring Attributes
        // Available only for the Init Recurring Sale 3D Request
        //$sale_3ds_v2_request
        //    ->setThreedsV2RecurringExpirationDate('12-12-2030')
        //    ->setThreedsV2RecurringFrequency(2);

    // Send the request
    $genesis->execute();

    // If there is an error - display the error information
    if (!$genesis->response()->isSuccessful()) {
        echo "Error code: {$genesis->response()->getResponseObject()->code}\n";
        echo "Message: {$genesis->response()->getResponseObject()->message}\n";
        echo "Technical message: {$genesis->response()->getResponseObject()->technical_message}\n";
    }

    // Un/Successfully completed the transaction - display the gateway unique id
    echo $genesis->response()->getResponseObject()->unique_id;

    // Status of the initial request
    $status = $genesis->response()->getResponseObject()->status ?? '';
    echo $status;

    switch ($status) {
        case \Genesis\Api\Constants\Transaction\States::APPROVED:
            // Transaction approved no customer action required
            // Test Case: Synchronous 3DSv2 Request with Frictionless flow
            break;
        case \Genesis\Api\Constants\Transaction\States::PENDING_ASYNC:
            // Additional Actions Required
            if (isset($genesis->response()->getResponseObject()->redirect_url)) {
                // An interaction between consumer and issuer is required
                // 3DSv2 Challenge required
                // 3DSv1 payer authentication required - fallback from 3DSv2 to 3DSv1
                // Test Case: Asynchronous 3DSv2 Request with Challenge flow
                // Test Case: Asynchronous 3DSv2 Request with Fallback flow
                echo $genesis->response()->getResponseObject()->redirect_url_type;
                echo $genesis->response()->getResponseObject()->redirect_url;
            }

            if (isset($genesis->response()->getResponseObject()->threeds_method_url)) {
                // 3DS-Method submission is required
                // Generate 3DSv2-Method Signature token used for 3DS-Method Continue Request. It's not required when the 3DS-Method continue request is built by the initial request's response object.
                echo $sale_3ds_v2_request->generateThreedsV2Signature();

                // Execute 3DS-Method Continue Request after initiating the 3DS-Method submission
                // The new request is loaded from the response object of the initial request
                $genesis_3ds_v2_continue = \Genesis\Api\Request\Financial\Cards\Threeds\V2\MethodContinue::buildFromResponseObject(
                    $genesis->response()->getResponseObject()
                );
                $genesis_3ds_v2_continue->execute();

                print_r($genesis_3ds_v2_continue->response()->getResponseObject());

                if ($genesis_3ds_v2_continue->response()->isApproved()) {
                    // Transaction APPROVED no customer action required
                    // Test Case: Asynchronous 3DSv2 Request with 3DS-Method and Frictionless flow
                }

                if ($genesis_3ds_v2_continue->response()->isPendingAsync()) {
                    // Customer action required
                    if (isset($genesis_3ds_v2_continue->response()->getResponseObject()->redirect_url)) {
                        // Test Case: Asynchronous 3DSv2 Request with 3DS-Method Challenge flow
                        // Test Case: Asynchronous 3DSv2 Request with 3DS-Method Fallback flow
                        echo $genesis_3ds_v2_continue->response()->getResponseObject()->redirect_url_type;
                        echo $genesis_3ds_v2_continue->response()->getResponseObject()->redirect_url;
                    }
                }
            }
            break;
        case \Genesis\Api\Constants\Transaction\States::DECLINED:
            // Transaction declined no customer action required
            // Synchronous 3DSv2 Request with Frictionless flow
            break;
    }    
}
// Log/handle invalid parameters
// Example: Empty (required) parameter
catch (\Genesis\Exceptions\ErrorParameter $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
catch (\Genesis\Exceptions\ErrorNetwork $network) {
    error_log($network->getMessage());
}
```

</details>

Example 3DSv2 Request via Web Payment Form

<details>
<summary>Details</summary>

```php
<?php
require 'vendor/autoload.php';

// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');

// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');

try {   
    // Create a new Genesis instance with desired API request
    $genesis = new \Genesis\Genesis('Wpf\Create');
    
    /** @var \Genesis\Api\Request\Wpf\Create $wpf_3ds_v2_request */
    $wpf_3ds_v2_request = $genesis->request();

    $wpf_3ds_v2_request
        ->setTransactionId('43671')
        ->setUsage('40208 concert tickets')
        ->setAmount('50')
        ->setCurrency('USD')

        // Return URLS
        ->setNotificationUrl('https://example.com/notification')
        ->setReturnSuccessUrl('https://example.com/return?type=success')
        ->setReturnFailureUrl('https://example.com/return?type=failure')
        ->setReturnCancelUrl('https://example.com/return?type=cancel')
        
        // Optional Url used for specific cases
        ->setReturnPendingUrl('https://example.com/return?type=pending')

        // Customer Details
        ->setCustomerEmail('john@example.com')
        ->setCustomerPhone('1987987987987')
        
        // Billing/Invoice Details
        ->setBillingFirstName('John')
        ->setBillingLastName('Smith')
        ->setBillingAddress1('Muster Str. 12')
        ->setBillingZipCode('10178')
        ->setBillingCity('Los Angeles')
        ->setBillingState('CA')
        ->setBillingCountry('US')

        // Optional Description
        ->setDescription('Example Description')
        
        // Desired Transaction Type
        ->addTransactionType('sale3d')

        // 3DSv2 Control Attributes
        ->setThreedsV2ControlChallengeWindowSize(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeWindowSizes::FULLSCREEN)
        ->setThreedsV2ControlChallengeIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Control\ChallengeIndicators::PREFERENCE)
 
        // 3DSv2 Purchase Attributes
        ->setThreedsV2PurchaseCategory(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\Purchase\Categories::SERVICE)
        
        // 3DSv2 Merchant Risk Attributes
        ->setThreedsV2MerchantRiskShippingIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\ShippingIndicators::VERIFIED_ADDRESS)
        ->setThreedsV2MerchantRiskDeliveryTimeframe(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\DeliveryTimeframes::ELECTRONICS)
        ->setThreedsV2MerchantRiskReorderItemsIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\ReorderItemIndicators::REORDERED)
        ->setThreedsV2MerchantRiskPreOrderPurchaseIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\MerchantRisk\PreOrderPurchaseIndicators::MERCHANDISE_AVAILABLE)
        ->setThreedsV2MerchantRiskPreOrderDate('31-12-2030') // For a pre-ordered purchase, the expected date that the merchandise will be available.
        ->setThreedsV2MerchantRiskGiftCard(true) // Boolean attribute. Accepts values like `on`, `off`, `yes`, `no`, `true`, `false`, etc...
        ->setThreedsV2MerchantRiskGiftCardCount(99)
        
        // 3DSSv2 Cardholder Account Attributes
        ->setThreedsV2CardHolderAccountCreationDate('31-12-2019')
        ->setThreedsV2CardHolderAccountUpdateIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\UpdateIndicators::FROM_30_TO_60_DAYS)
        ->setThreedsV2CardHolderAccountLastChangeDate('31-12-2019')
        ->setThreedsV2CardHolderAccountPasswordChangeIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\PasswordChangeIndicators::NO_CHANGE)
        ->setThreedsV2CardHolderAccountPasswordChangeDate('31-12-2019')
        ->setThreedsV2CardHolderAccountShippingAddressUsageIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\ShippingAddressUsageIndicators::CURRENT_TRANSACTION)
        ->setThreedsV2CardHolderAccountShippingAddressDateFirstUsed('31-12-2019')
        ->setThreedsV2CardHolderAccountTransactionsActivityLast24Hours(2)
        ->setThreedsV2CardHolderAccountTransactionsActivityPreviousYear(10)
        ->setThreedsV2CardHolderAccountProvisionAttemptsLast24Hours(1)
        ->setThreedsV2CardHolderAccountPurchasesCountLast6Months(5)
        ->setThreedsV2CardHolderAccountSuspiciousActivityIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\SuspiciousActivityIndicators::NO_SUSPICIOUS_OBSERVED)
        ->setThreedsV2CardHolderAccountRegistrationIndicator(\Genesis\Api\Constants\Transaction\Parameters\Threeds\V2\CardHolderAccount\RegistrationIndicators::FROM_30_TO_60_DAYS)
        ->setThreedsV2CardHolderAccountRegistrationDate('31-12-2019')

        // 3DSv2 Recurring Attributes
        // Available only for the Init Recurring Sale 3D Request
        ->setThreedsV2RecurringExpirationDate('12-12-2030') // A future date indicating the end date for any further subsequent transactions.
        ->setThreedsV2RecurringFrequency(2);

    // Send the request
    $genesis->execute();

    // If there is an error - display the error information
    if (!$genesis->response()->isSuccessful()) {
        echo "Error code: {$genesis->response()->getResponseObject()->code}\n";
        echo "Message: {$genesis->response()->getResponseObject()->message}\n";
        echo "Technical message: {$genesis->response()->getResponseObject()->technical_message}\n";
    }

    // Upon successful `$genesis->response()->isNew()`
    // Redirect to the Web Payment Form
    echo $genesis->response()->getResponseObject()->redirect_url;
    
    // ThreedsV2 Signature
    echo $genesis->request()->generateThreedsV2Signature();  
}
// Log/handle invalid parameters
// Example: Empty (required) parameter
catch (\Genesis\Exceptions\ErrorParameter $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
catch (\Genesis\Exceptions\ErrorNetwork $network) {
    error_log($network->getMessage());
}
```
</details>


Standalone ThreedsV2 Method Continue Request.

<details>

```php
<?php
require 'vendor/autoload.php';

// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');

// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');
\Genesis\Config::setToken('<enter_your_token>');

try {   
    // Create a new Genesis instance with desired API request
    $genesis_3ds_v2_continue = new \Genesis\Genesis('Financial\Cards\Threeds\V2\MethodContinue');

    /** @var \Genesis\Api\Request\Financial\Cards\Threeds\V2\MethodContinue $continueRequest */
    $genesis_3ds_v2_continue_request = $genesis_3ds_v2_continue->request();

    $genesis_3ds_v2_continue_request
        // Amount in minor currency unit
        // If the AMOUNT is not in a minor currency unit then SET the CURRENCY. The AMOUNT will be converted into minor currency unit internally using the CURRENCY property.
        // Ex. ->setAmount(10.00)->setCurrency('EUR'); The AMOUNT in that case for signature generation will be 1000
        // Amount is included in the response from the initial request in major currency unit $genesis->response()->getResponseObject()->amount
        ->setAmount(10.00)
        // If CURRENCY is set, AMOUNT value will be converted into MINOR currency unit
        // If you SET the AMOUNT in MINOR currency unit DO NOT set CURRENCY
        // Currency is included in the response from the initial request in major currency unit $genesis->response()->getResponseObject()->currency
        ->setCurrency('EUR')

        // Set only one of the unique_id or url
        //->setUrl("https://staging.gate.emerchantpay.net/threeds/threeds_method/d6a6aa96292e4856d4a352ce634a4335")
        ->setTransactionUniqueId('d6a6aa96292e4856d4a352ce634a4335')

        // String representation of the timestamp
        // ->setTransactionTimestamp(
        //     $responseObject->timestamp->format(
        //         \Genesis\Api\Constants\DateTimeFormat::YYYY_MM_DD_H_I_S_ZULU
        //     )
        // )
        ->setTransactionTimestamp('2020-12-31T23:59:59Z');

    $genesis_3ds_v2_continue->execute();

    // If there is an error - display the error information
    if (!$genesis_3ds_v2_continue->response()->isSuccessful()) {
        echo "Error code: {$genesis_3ds_v2_continue->response()->getResponseObject()->code}\n";
        echo "Message: {$genesis_3ds_v2_continue->response()->getResponseObject()->message}\n";
        echo "Technical message: {$genesis_3ds_v2_continue->response()->getResponseObject()->technical_message}\n";
    }

    $status = $genesis_3ds_v2_continue->response()->getResponseObject()->status ?? '';

    switch ($status) {
            // Asynchronous 3DSv2 Request with 3DS-Method and Frictionless flow
            // Transaction approved no customer action required
            break;
        case \Genesis\Api\Constants\Transaction\States::PENDING_ASYNC:
            // Customer action required
            if (isset($genesis_3ds_v2_continue->response()->getResponseObject()->redirect_url)) {
                // Asynchronous 3DSv2 Request with 3DS-Method Challenge flow
                // Asynchronous 3DSv2 Request with 3DS-Method Fallback flow
                echo $genesis_3ds_v2_continue->response()->getResponseObject()->redirect_url_type;
                echo $genesis_3ds_v2_continue->response()->getResponseObject()->redirect_url;
            }
            break;
    }
}
// Log/handle invalid parameters
// Example: Empty (required) parameter
catch (\Genesis\Exceptions\ErrorParameter $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
catch (\Genesis\Exceptions\ErrorNetwork $network) {
    error_log($network->getMessage());
}

```

</details>

Example Google Pay
------------------
<details>
<summary>Example Google Pay transaction request</summary>

```php
<?php
require 'vendor/autoload.php';
// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');
// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');
\Genesis\Config::setToken('<enter_your_token>');

// Google Pay token
$jsonToken = "{\"protocolVersion\":\"ECv2\",\"signature\":\"MEQCIH6Q4OwQ0jAceFEkGF0JID6sJNXxOEi4r+mA7biRxqBQAiAondqoUpU\/bdsrAOpZIsrHQS9nwiiNwOrr24RyPeHA0Q\\u003d\\u003d\",\"intermediateSigningKey\":{\"signedKey\": \"{\\\"keyExpiration\\\":\\\"1542323393147\\\",\\\"keyValue\\\":\\\"MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAE\/1+3HBVSbdv+j7NaArdgMyoSAM43yRydzqdg1TxodSzA96Dj4Mc1EiKroxxunavVIvdxGnJeFViTzFvzFRxyCw\\u003d\\u003d\\\"}\", \"signatures\": [\"MEYCIQCO2EIi48s8VTH+ilMEpoXLFfkxAwHjfPSCVED\/QDSHmQIhALLJmrUlNAY8hDQRV\/y1iKZGsWpeNmIP+z+tCQHQxP0v\"]},\"signedMessage\":\"{\\\"tag\\\":\\\"jpGz1F1Bcoi\/fCNxI9n7Qrsw7i7KHrGtTf3NrRclt+U\\u003d\\\",\\\"ephemeralPublicKey\\\":\\\"BJatyFvFPPD21l8\/uLP46Ta1hsKHndf8Z+tAgk+DEPQgYTkhHy19cF3h\/bXs0tWTmZtnNm+vlVrKbRU9K8+7cZs\\u003d\\\",\\\"encryptedMessage\\\":\\\"mKOoXwi8OavZ\\\"}\"}";
$decodedToken = json_decode($jsonToken, true);

// Create a new Genesis instance with Google Pay API request
$genesis = new Genesis('Financial\Mobile\GooglePay');

// Set request parameters
$genesis->request()
    // Add Google Pay token details  
    // Use ->setJsonToken($jsonToken) with JSON string for $jsonToken
    ->setTokenSignature($decodedToken['signature'])
    ->setTokenSignedKey($decodedToken['intermediateSigningKey']['signedKey'])
    ->setTokenProtocolVersion($decodedToken['protocolVersion'])
    ->setTokenSignedMessage($decodedToken['signedMessage'])
    ->setTokenSignatures($decodedToken['intermediateSigningKey']['signatures']) // Token Signatures accepts array value
    // Set request parameters
    ->setTransactionId('43671')
    ->setPaymentSubtype(\Genesis\Api\Constants\Transaction\Parameters\Mobile\GooglePay\PaymentTypes::SALE)
    ->setUsage('40208 concert tickets')
    ->setRemoteIp('245.253.2.12')
    ->setAmount('50')
    ->setCurrency('USD')
    // Customer Details
    ->setCustomerEmail('travis@example.com')
    ->setCustomerPhone('1987987987987')
    // Billing/Invoice Details
    ->setBillingFirstName('Travis')
    ->setBillingLastName('Pastrana')
    ->setBillingAddress1('Muster Str. 12')
    ->setBillingZipCode('10178')
    ->setBillingCity('Los Angeles')
    ->setBillingState('CA')
    ->setBillingCountry('US')
    // Shipping Details
    ->setShippingFirstName('Travis')
    ->setShippingLastName('Pastrana')
    ->setShippingAddress1('Muster Str. 12')
    ->setShippingZipCode('10178')
    ->setShippingCity('Los Angeles')
    ->setShippingState('CA')
    ->setShippingCountry('US');

try {
    // Send the request
    $genesis->execute();

    // If there is an error - display the error information
    if (!$genesis->response()->isSuccessful()) {
        echo "Error code: {$genesis->response()->getResponseObject()->code}\n";
        echo "Message: {$genesis->response()->getResponseObject()->message}\n";
        echo "Technical message: {$genesis->response()->getResponseObject()->technical_message}\n";
    }

    // Successfully completed the transaction - display the gateway unique id
    echo $genesis->response()->getResponseObject()->unique_id;
}
// Log/handle invalid parameters
// Example: Empty (required) parameter
catch (\Genesis\Exceptions\ErrorParameter $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
catch (\Genesis\Exceptions\ErrorNetwork $network) {
    error_log($network->getMessage());
}

```
</details>

<details>
<summary>Example Google Pay WPF request</summary>

```php
<?php
require 'vendor/autoload.php';
// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');
// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');

// Create a new Genesis instance with Web Payment Form request
$genesis = new Genesis('Wpf\Create');

// Set request parameters
$genesis
    ->request()
    ->setTransactionId('43671')
    ->setUsage('40208 concert tickets')
    ->setDescription('WPF Google Pay test transaction')
    ->setAmount('50')
    ->setCurrency('USD')

    // Customer Details
    ->setCustomerEmail('travis@example.com')
    ->setCustomerPhone('1987987987987')

    ->setNotificationUrl('https://example.com/notification')
    ->setReturnSuccessUrl('https://example.com/return?type=success')
    ->setReturnFailureUrl('https://example.com/return?type=failure')
    ->setReturnCancelUrl('https://example.com/return?type=cancel')
        
    // Billing/Invoice Details
    ->setBillingFirstName('Travis')
    ->setBillingLastName('Pastrana')
    ->setBillingAddress1('Muster Str. 12')
    ->setBillingZipCode('10178')
    ->setBillingCity('Los Angeles')
    ->setBillingState('CA')
    ->setBillingCountry('US')

    // Shipping Details
    ->setShippingFirstName('Travis')
    ->setShippingLastName('Pastrana')
    ->setShippingAddress1('Muster Str. 12')
    ->setShippingZipCode('10178')
    ->setShippingCity('Los Angeles')
    ->setShippingState('CA')
    ->setShippingCountry('US')
    ->setLanguage(\Genesis\Api\Constants\i18n::EN)
    ->addTransactionType('google_pay', ['payment_subtype' => 'sale']);

try {
    // Send the request
    $genesis->execute();

    // If there is an error - display the error information
    if (!$genesis->response()->isSuccessful()) {
        echo "Error code: {$genesis->response()->getResponseObject()->code}\n";
        echo "Message: {$genesis->response()->getResponseObject()->message}\n";
        echo "Technical message: {$genesis->response()->getResponseObject()->technical_message}\n";
    }

    // Successfully completed the transaction - display the gateway unique id
    echo $genesis->response()->getResponseObject()->unique_id;
}
// Log/handle invalid parameters
// Example: Empty (required) parameter
catch (\Genesis\Exceptions\ErrorParameter $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
catch (\Genesis\Exceptions\ErrorNetwork $network) {
    error_log($network->getMessage());
}

```
</details>

Example Apple Pay
------------------
<details>
<summary>Example Apple Pay transaction request</summary>

```php
<?php
require 'vendor/autoload.php';
// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');
// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');
\Genesis\Config::setToken('<enter_your_token>');

// Apple Pay token
$jsonToken = "{\"protocolVersion\":\"ECv2\",\"signature\":\"MEQCIH6Q4OwQ0jAceFEkGF0JID6sJNXxOEi4r+mA7biRxqBQAiAondqoUpU\/bdsrAOpZIsrHQS9nwiiNwOrr24RyPeHA0Q\\u003d\\u003d\",\"intermediateSigningKey\":{\"signedKey\": \"{\\\"keyExpiration\\\":\\\"1542323393147\\\",\\\"keyValue\\\":\\\"MFkwEwYHKoZIzj0CAQYIKoZIzj0DAQcDQgAE\/1+3HBVSbdv+j7NaArdgMyoSAM43yRydzqdg1TxodSzA96Dj4Mc1EiKroxxunavVIvdxGnJeFViTzFvzFRxyCw\\u003d\\u003d\\\"}\", \"signatures\": [\"MEYCIQCO2EIi48s8VTH+ilMEpoXLFfkxAwHjfPSCVED\/QDSHmQIhALLJmrUlNAY8hDQRV\/y1iKZGsWpeNmIP+z+tCQHQxP0v\"]},\"signedMessage\":\"{\\\"tag\\\":\\\"jpGz1F1Bcoi\/fCNxI9n7Qrsw7i7KHrGtTf3NrRclt+U\\u003d\\\",\\\"ephemeralPublicKey\\\":\\\"BJatyFvFPPD21l8\/uLP46Ta1hsKHndf8Z+tAgk+DEPQgYTkhHy19cF3h\/bXs0tWTmZtnNm+vlVrKbRU9K8+7cZs\\u003d\\\",\\\"encryptedMessage\\\":\\\"mKOoXwi8OavZ\\\"}\"}";
$decodedToken = json_decode($jsonToken, true);

// Create a new Genesis instance with Apple Pay API request
$genesis = new Genesis('Financial\Mobile\ApplePay');

// Set request parameters
$genesis->request()
    // Add Apple Pay token details
    // Use ->setJsonToken($jsonToken) with JSON string for $jsonToken
    ->setTokenVersion($decodedToken['paymentData']['version'])
    ->setTokenData($decodedToken['paymentData']['data'])
    ->setTokenSignature($decodedToken['paymentData']['signature'])
    ->setTokenEphemeralPublicKey($decodedToken['paymentData']['header']['ephemeralPublicKey'])
    ->setTokenPublicKeyHash($decodedToken['paymentData']['header']['publicKeyHash'])
    ->setTokenTransactionId($decodedToken['paymentData']['header']['transactionId'])
    ->setTokenDisplayName($decodedToken['paymentMethod']['displayName'])
    ->setTokenNetwork($decodedToken['paymentMethod']['network'])
    ->setTokenType($decodedToken['paymentMethod']['type'])
    ->setTokenTransactionIdentifier($decodedToken['transactionIdentifier'])
    // Set request parameters
    ->setTransactionId('43671')
    ->setPaymentSubtype(\Genesis\Api\Constants\Transaction\Parameters\Mobile\ApplePay\PaymentTypes::SALE)
    ->setUsage('40208 concert tickets')
    ->setRemoteIp('245.253.2.12')
    ->setAmount('50')
    ->setCurrency('USD')
    // Customer Details
    ->setCustomerEmail('travis@example.com')
    ->setCustomerPhone('1987987987987')
    // Billing/Invoice Details
    ->setBillingFirstName('Travis')
    ->setBillingLastName('Pastrana')
    ->setBillingAddress1('Muster Str. 12')
    ->setBillingZipCode('10178')
    ->setBillingCity('Los Angeles')
    ->setBillingState('CA')
    ->setBillingCountry('US')
    // Shipping Details
    ->setShippingFirstName('Travis')
    ->setShippingLastName('Pastrana')
    ->setShippingAddress1('Muster Str. 12')
    ->setShippingZipCode('10178')
    ->setShippingCity('Los Angeles')
    ->setShippingState('CA')
    ->setShippingCountry('US');

try {
    // Send the request
    $genesis->execute();

    // If there is an error - display the error information
    if (!$genesis->response()->isSuccessful()) {
        echo "Error code: {$genesis->response()->getResponseObject()->code}\n";
        echo "Message: {$genesis->response()->getResponseObject()->message}\n";
        echo "Technical message: {$genesis->response()->getResponseObject()->technical_message}\n";
    }

    // Successfully completed the transaction - display the gateway unique id
    echo $genesis->response()->getResponseObject()->unique_id;
}
// Log/handle invalid parameters
// Example: Empty (required) parameter
catch (\Genesis\Exceptions\ErrorParameter $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
catch (\Genesis\Exceptions\ErrorNetwork $network) {
    error_log($network->getMessage());
}

```
</details>

<details>
<summary>Example Apple Pay WPF request</summary>

```php
<?php
require 'vendor/autoload.php';
// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');
// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');

// Create a new Genesis instance with Web Payment Form request
$genesis = new Genesis('Wpf\Create');

// Set request parameters
$genesis
    ->request()
    ->setTransactionId('43671')
    ->setUsage('40208 concert tickets')
    ->setDescription('WPF Apple Pay test transaction')
    ->setAmount('50')
    ->setCurrency('USD')

    // Customer Details
    ->setCustomerEmail('travis@example.com')
    ->setCustomerPhone('1987987987987')

    ->setNotificationUrl('https://example.com/notification')
    ->setReturnSuccessUrl('https://example.com/return?type=success')
    ->setReturnFailureUrl('https://example.com/return?type=failure')
    ->setReturnCancelUrl('https://example.com/return?type=cancel')
        
    // Billing/Invoice Details
    ->setBillingFirstName('Travis')
    ->setBillingLastName('Pastrana')
    ->setBillingAddress1('Muster Str. 12')
    ->setBillingZipCode('10178')
    ->setBillingCity('Los Angeles')
    ->setBillingState('CA')
    ->setBillingCountry('US')

    // Shipping Details
    ->setShippingFirstName('Travis')
    ->setShippingLastName('Pastrana')
    ->setShippingAddress1('Muster Str. 12')
    ->setShippingZipCode('10178')
    ->setShippingCity('Los Angeles')
    ->setShippingState('CA')
    ->setShippingCountry('US')
    ->setLanguage(\Genesis\Api\Constants\i18n::EN)
    ->addTransactionType('apple_pay', ['payment_subtype' => 'sale']);

try {
    // Send the request
    $genesis->execute();

    // If there is an error - display the error information
    if (!$genesis->response()->isSuccessful()) {
        echo "Error code: {$genesis->response()->getResponseObject()->code}\n";
        echo "Message: {$genesis->response()->getResponseObject()->message}\n";
        echo "Technical message: {$genesis->response()->getResponseObject()->technical_message}\n";
    }

    // Successfully completed the transaction - display the gateway unique id
    echo $genesis->response()->getResponseObject()->unique_id;
}
// Log/handle invalid parameters
// Example: Empty (required) parameter
catch (\Genesis\Exceptions\ErrorParameter $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
catch (\Genesis\Exceptions\ErrorNetwork $network) {
    error_log($network->getMessage());
}

```
</details>

Example Web Payment Form transaction request with Zero Amount
-------------
In certain cases, it is possible to submit a transaction with a zero-value amount in order not to charge the consumer with the initial recurring, but with the followed RecurringSale transactions only - ***Free Trial***.

<details>
<summary>Example WPF Request</summary>

```php
<?php
require 'vendor/autoload.php';

// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');

// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');

try {
    // Create a new Genesis instance with desired API request
    $genesis = new \Genesis\Genesis('Wpf\Create');

    /** @var \Genesis\Api\Request\Wpf\Create $wpf_recurring_request */
    $wpf_recurring_request = $genesis->request();
    $wpf_recurring_request
        ->setTransactionId('43671')
        ->setUsage('40208 concert tickets')
        ->setAmount('0')
        ->setCurrency('USD')
        // Return URLS
        ->setNotificationUrl('https://example.com/notification')
        ->setReturnSuccessUrl('https://example.com/return?type=success')
        ->setReturnFailureUrl('https://example.com/return?type=failure')
        ->setReturnCancelUrl('https://example.com/return?type=cancel')

        // Optional Url used for specific cases
        ->setReturnPendingUrl('https://example.com/return?type=pending')
        // Customer Details
        ->setCustomerEmail('john@example.com')
        ->setCustomerPhone('1987987987987')

        // Billing/Invoice Details
        ->setBillingFirstName('John')
        ->setBillingLastName('Smith')
        ->setBillingAddress1('Muster Str. 12')
        ->setBillingZipCode('10178')
        ->setBillingCity('Los Angeles')
        ->setBillingState('CA')
        ->setBillingCountry('US')
        // Optional Description
        ->setDescription('Example Description')

        // Desired Transaction Type
        ->addTransactionType('init_recurring_sale');
        // Example: Recurring V2 available for following transaction types: sale, sale3d, authorize, authorize3d
        // Recurring Type can have one value of 'initial' or 'managed'
        // ->addTransactionType('sale', ['recurring_type' => 'initial']);

    // Send the request
    $genesis->execute();

    // If there is an error - display the error information
    if (!$genesis->response()->isSuccessful()) {
        echo "Error code: {$genesis->response()->getResponseObject()->code}\n";
        echo "Message: {$genesis->response()->getResponseObject()->message}\n";
        echo "Technical message: {$genesis->response()->getResponseObject()->technical_message}\n";
    }

    // Upon successful `$genesis->response()->isNew()`
    // Redirect to the Web Payment Form
    echo $genesis->response()->getResponseObject()->redirect_url;
}
// Log/handle invalid parameters
// Example: Empty (required) parameter
catch (\Genesis\Exceptions\ErrorParameter $parameter) {
    error_log($parameter->getMessage());
}
// Log/handle network (transport) errors
// Example: SSL verification errors, Timeouts
catch (\Genesis\Exceptions\ErrorNetwork $network) {
    error_log($network->getMessage());
}
```

</details>

Notifications
-------------

When using an Asynchronous workflow, you need to parse the incoming extension in order to ensure its authenticity and verify it against Genesis server.

Example:

```php
<?php  
require 'vendor/autoload.php';   

// Load the pre-configured ini file...
\Genesis\Config::loadSettings('/path/to/config.ini');

// ...OR, optionally, you can set the credentials manually
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
\Genesis\Config::setEnvironment(\Genesis\Api\Constants\Environments::STAGING);
\Genesis\Config::setUsername('<enter_your_username>');
\Genesis\Config::setPassword('<enter_your_password>');

// Add your Terminal Token for all Non-WPF (Web Payment Form/Checkout) requests
\Genesis\Config::setToken('<enter_your_token>');

try {
    $notification = new \Genesis\Api\Notification($_POST);

    // Reconciliation is generally optional, but
    // it's a recommended practice to ensure
    // that you have the latest information
    $notification->initReconciliation();

    // Application Logic
    // ...
    // for example, process the transaction status
    // $status = $notification->getReconciliationObject()->status;

    // Respond to Genesis
    $notification->renderResponse();
}
catch (\Exception $e) {
    error_log($e->getMessage());
}

?>
```

Endpoints
---------

The current versions supports two separate endpoints: ```E-ComProcessing``` and ```emerchantpay```

For example:

- You can set the Endpoint to ```E-ComProcessing```, thus all the requests will go to ```E-ComProcessing```s Genesis instance:
```php
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::ECOMPROCESSING);
```

- You can set the Endpoint to ```emerchantpay```, thus all the requests will go to ```emerchantpay```s Genesis instance:
```php
\Genesis\Config::setEndpoint(\Genesis\Api\Constants\Endpoints::EMERCHANTPAY);
```

Request types
-------------

You can use the following request types to initialize the Genesis client:

```text
// Generic transaction operations
Financial\Capture
Financial\Refund
Financial\Cancel

// Alternative Payment Methods transactions
Financial\Alternatives\P24
Financial\Alternatives\Poli
Financial\Alternatives\Ppro
Financial\Alternatives\Sofort
Financial\Alternatives\Klarna\Authorize
Financial\Alternatives\Klarna\Capture
Financial\Alternatives\Klarna\Refund
Financial\Alternatives\TransferTo\Payout
Financial\Alternatives\Trustly\Sale

// Credit Cards transactions
Financial\Cards\Argencard
Financial\Cards\Aura
Financial\Cards\Authorize
Financial\Cards\Authorize3D
Financial\Cards\Bancontact
Financial\Cards\Cabal
Financial\Cards\Cencosud
Financial\Cards\Credit
Financial\Cards\Elo
Financial\Cards\EzeeCardPayout
Financial\Cards\Naranja
Financial\Cards\Nativa
Financial\Cards\Payout
Financial\Cards\Sale
Financial\Cards\Sale3D
Financial\Cards\TarjetaShopping

// Cash Payments transactions
Financial\CashPayments\Baloto
Financial\CashPayments\BancoDeOccidente
Financial\CashPayments\Boleto
Financial\CashPayments\Efecty
Financial\CashPayments\Oxxo
Financial\CashPayments\PagoFacil
Financial\CashPayments\Pix
Financial\CashPayments\Redpagos

// Crypto transactions
Financial\Crypto\BitPay\Sale
Financial\Crypto\BitPay\Refund
Financial\Crypto\BitPay\Payout

// Gift Cards transactions
Financial\GiftCards\Intersolve
Financial\GiftCards\Fashioncheque
Financial\GiftCards\Tcs

// Mobile
Financial\Mobile\ApplePay
Financial\Mobile\GooglePay
Financial\Mobile\RussianMobileSale
Financial\Mobile\AfricanMobileSale

//Sepa Direct Debit transactions
Financial\Sct\Payout
Financial\Sdd\Sale
Financial\Sdd\Refund
Financial\Sdd\Recurring\InitRecurringSale
Financial\Sdd\Recurring\RecurringSale

//Online Banking Payments
Financial\OnlineBankingPayments\BancoDoBrasil
Financial\OnlineBankingPayments\Bancomer
Financial\OnlineBankingPayments\Bradesco
Financial\OnlineBankingPayments\Davivienda
Financial\OnlineBankingPayments\Eps
Financial\OnlineBankingPayments\Ideal
Financial\OnlineBankingPayments\Idebit\Payin
Financial\OnlineBankingPayments\Idebit\Payout
Financial\OnlineBankingPayments\InstaDebit\Payin
Financial\OnlineBankingPayments\InstaDebit\Payout
Financial\OnlineBankingPayments\Itau
Financial\OnlineBankingPayments\Multibanco
Financial\OnlineBankingPayments\MyBank
Financial\OnlineBankingPayments\OnlineBanking\Payin
Financial\OnlineBankingPayments\OnlineBanking\Payout
Financial\OnlineBankingPayments\PayU
Financial\OnlineBankingPayments\PostFinance
Financial\OnlineBankingPayments\Pse
Financial\OnlineBankingPayments\RapiPago
Financial\OnlineBankingPayments\SafetyPay
Financial\OnlineBankingPayments\Santander
Financial\OnlineBankingPayments\TrustPay
Financial\OnlineBankingPayments\Upi
Financial\OnlineBankingPayments\Webpay
Financial\OnlineBankingPayments\WeChat

//Payout
Financial\Payout\AfricanMobilePayout
Financial\Payout\RussianMobilePayout

// Preauthorization
Financial\Preauthorization\IncrementalAuthorize
Financial\Preauthorization\PartialReversal

// Vouchers
Financial\Vouchers\CashU
Financial\Vouchers\Neosurf
Financial\Vouchers\Paysafecard

// Electronic Wallets transactions
Financial\Wallets\EzeeWallet
Financial\Wallets\PayPal
Financial\Wallets\Neteller
Financial\Wallets\WebMoney

// Generic (Non-Financial) requests
NonFinancial\Blacklist

// Consumers API requests
NonFinancial\Consumers\Create
NonFinancial\Consumers\Retrieve
NonFinancial\Consumers\Update
NonFinancial\Consumers\Disable
NonFinancial\Consumers\Enable
NonFinancial\Consumers\GetCards

// Chargeback information request
NonFinancial\Fraud\Chargeback\DateRange
NonFinancial\Fraud\Chargeback\Transaction

// SAFE/TC40 Report
NonFinancial\Fraud\Reports\DateRange
NonFinancial\Fraud\Reports\Transaction

// Retrieval request
NonFinancial\Fraud\Retrieval\DateRange
NonFinancial\Fraud\Retrieval\Transaction

// Fx requests
NonFinancial\Fx\GetTiers
NonFinancial\Fx\GetTier
NonFinancial\Fx\GetRates
NonFinancial\Fx\GetRate
NonFinancial\Fx\SearchRate

// KYC requests
NonFinancial\Kyc\Call\Create
NonFinancial\Kyc\Call\Update
NonFinancial\Kyc\ConsumerRegistration\Create
NonFinancial\Kyc\ConsumerRegistration\Update
NonFinancial\Kyc\IdentityDocument\Download
NonFinancial\Kyc\IdentityDocument\Upload
NonFinancial\Kyc\Transaction\Create
NonFinancial\Kyc\Transaction\Update

// Reconcile requests
NonFinancial\Reconcile\DateRange
NonFinancial\Reconcile\Transaction

// SCA Checker API
NonFinancial\Sca\Checker

// Processed Transactions API
NonFinancial\ProcessedTransactions\Transaction
NonFinancial\ProcessedTransactions\DateRange
NonFinancial\ProcessedTransactions\PostDateRange

// TransferTo Payers API
NonFinancial\Alternatives\TransferTo\Payers

// Web Payment Form (Checkout) requests
Wpf\Create
Wpf\Reconcile

// Transaction API
NonFinancial\TransactionApi\CardExpiryDateUpdate

// ThreedsV2-Method Continue Request
Financial\Cards\Threeds\V2\MethodContinue

// Tokenization API
NonFinancial\TokenizationApi\Tokenize
NonFinancial\TokenizationApi\Detokenize
NonFinancial\TokenizationApi\UpdateToken
NonFinancial\TokenizationApi\ValidateToken
NonFinancial\TokenizationApi\DeleteToken
NonFinancial\TokenizationApi\GetCard

// Billing Transactions API
NonFinancial\BillingApi\Transaction

// APM Klarna Services
NonFinancial\Alternatives\Klarna\ReleaseAuthorization
NonFinancial\Alternatives\Klarna\ResendInvoice
NonFinancial\Alternatives\Klarna\UpdateAddress
NonFinancial\Alternatives\Klarna\UpdateItems

// Processed Batches API - Available only via E-Comprocessing endpoint
NonFinancial\ProcessedBatches\PostDateRange

// Trustly APM Services
NonFinancial\Alternatives\Trustly\RegisterAccount
NonFinancial\Alternatives\Trustly\SelectAccount
```

More information about each one of the request types can be found in the Genesis API Documentation and the Wiki

Running Specs
--------------

The following step are optional, however it's recommended to run specs at least once, in order to ensure that everything is working as intended on your setup

* install [Composer] (if you don't have it already)
```sh
curl -sS https://getcomposer.org/installer | php
```

* fetch all required packages
```sh
php composer.phar install
```

* run phpspec
```sh
php vendor/bin/phpspec run
```

Note: The specs are intended to run with PHP v8.1

[Composer]: https://getcomposer.org/
