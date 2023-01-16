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
 * @copyright   Copyright (C) 2015-2023 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */
namespace Genesis\API\Constants;

/**
 * Error codes used by Genesis / Issuer
 *
 * @package    Genesis
 * @subpackage API
 *
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 */
final class Errors
{
    /**
     * Successfully completed request
     */
    const SUCCESS                                       = 000;

    /**
     * Undefined error
     */
    const ERROR                                         = 001;

    /**
     * A general system error occurred
     */
    const SYSTEM_ERROR                                  = 100;

    /**
     * System is undergoing maintenance, request could not be handled
     */
    const MAINTENANCE_ERROR                             = 101;

    /**
     * Login failed. Check your API credentials.
     */
    const AUTHENTICATION_ERROR                          = 110;

    /**
     * Config error occurred, e.g. terminal not configured properly.
     *
     * Check terminal settings
     */
    const CONFIGURATION_ERROR                           = 120;

    /**
     * Communication with issuer failed, please contact support.
     */
    const COMMUNICATION_ERROR                           = 200;

    /**
     * Connection to issuer could not be established, please contact support
     */
    const CONNECTION_ERROR                              = 210;

    /**
     * Issuer account data invalid, please contact support
     */
    const ACCOUNT_ERROR                                 = 220;

    /**
     * Issuer does not respond within given time-frame - please reconcile
     */
    const TIMEOUT_ERROR                                 = 230;

    /**
     * Issuer returned invalid response - please reconcile and contact support
     */
    const RESPONSE_ERROR                                = 240;

    /**
     * Issuer response could not be parsed - please reconcile and contact support
     */
    const PARSING_ERROR                                 = 250;

    /**
     * Invalid data were sent to the API.
     */
    const INPUT_DATA_ERROR                              = 300;

    /**
     * Invalid transaction type was passed to API
     */
    const INVALID_TRANSACTION_TYPE_ERROR                = 310;

    /**
     * Required argument is missing
     */
    const INPUT_DATA_MISSING_ERROR                      = 320;

    /**
     * Argument passed in invalid format
     */
    const INPUT_DATA_FORMAT_ERROR                       = 330;

    /**
     * This is a format error stopped by MasterCard due to invalid formatting in certain fields.
     */
    const MASTERCARD_FORMAT_ERROR                       = 331;

    /**
     * Argument passed in valid format but makes no sense (e.g. incorrect country code or currency)
     */
    const INPUT_DATA_INVALID_ERROR                      = 340;

    /**
     * The input Builder could not be parsed due to invalid code
     */
    const INVALID_XML_ERROR                             = 350;

    /**
     * Invalid value for HTTP header - Content-Type
     */
    const INVALID_CONTENT_TYPE_ERROR                    = 360;

    /**
     * A transaction was triggered that is not possible at this time in the workflow,
     * e.g. a refund on a declined transaction.
     */
    const WORKFLOW_ERROR                                = 400;

    /**
     * Reference transaction was not found.
     */
    const REFERENCE_NOT_FOUND_ERROR                     = 410;

    /**
     * Wrong Workflow specified
     */
    const REFERENCE_WORKFLOW_ERROR                      = 420;

    /**
     * Reference transaction already invalidated
     */
    const REFERENCE_INVALIDATED_ERROR                   = 430;

    /**
     * Data mismatch with reference, e.g. amount exceeds reference
     */
    const REFERENCE_MISMATCH_ERROR                      = 440;

    /**
     * Transaction doublet was detected, transaction was blocked
     */
    const DOUBLE_TRANSACTION_ERROR                      = 450;

    /**
     * The referenced transaction could not be found
     */
    const TRANSACTION_NOT_FOUND_ERROR                   = 460;

    /**
     * Chargeback not found!
     */
    const CHARGEBACK_NOT_FOUND_ERROR                    = 470;

    /**
     * Retrieval Request not found!
     */
    const RETRIEVAL_REQUEST_NOT_FOUND_ERROR             = 480;

    /**
     * Fraud Report not found!
     */
    const FRAUD_REPORT_NOT_FOUND_ERROR                  = 490;

    /**
     * Transaction declined by issuer
     */
    const PROCESSING_ERROR                              = 500;

    /**
     * Transaction declined, Credit card number is invalid
     */
    const INVALID_CARD_ERROR                            = 510;

    /**
     * OCT not enabled error.
     */
    const ISSUER_OCT_NOT_ENABLED_ERROR                  = 511;

    /**
     * Transaction declined, expiration date not in the future or date invalid
     */
    const EXPIRED_CARD_ERROR                            = 520;

    /**
     * Transaction pending
     */
    const TRANSACTION_PENDING_ERROR                     = 530;

    /**
     * Amount exceeds credit card limit
     */
    const CREDIT_EXCEEDED_ERROR                         = 540;

    /**
     * The voucher could not be issued!
     */
    const ISSUING_ERROR                                 = 550;

    /**
     * Transaction declined by risk management
     */
    const RISK_ERROR                                    = 600;

    /**
     * Interchange reject received for transaction!
     */
    const INTERCHANGE_REJECT_ERROR                      = 601;

    /**
     * Transaction declined by frontend reject!
     */
    const FRONT_END_REJECT_ERROR                        = 602;

    /**
     * Card bin does not match billing country
     */
    const BIN_COUNTRY_CHECK_ERROR                       = 609;

    /**
     * Card is blacklisted
     */
    const CARD_BLACKLIST_ERROR                          = 610;

    /**
     * BIN blacklisted
     */
    const BIN_BLACKLIST_ERROR                           = 611;

    /**
     * Country blacklisted
     */
    const COUNTRY_BLACKLIST_ERROR                       = 612;

    /**
     * IP address blacklisted
     */
    const IP_BLACKLIST_ERROR                            = 613;

    /**
     * Value from the Transaction Request or Risk Parameters is blacklisted
     */
    const BLACKLIST_ERROR                               = 614;

    /**
     * PAN Whitelist Filter blocked the transaction
     */
    const CARD_WHITELIST_ERROR                          = 615;

    /**
     * Card limit exceeded configured limits
     */
    const CARD_LIMIT_EXCEEDED_ERROR                     = 620;

    /**
     * Terminal limits exceeded.
     */
    const TERMINAL_LIMIT_EXCEEDED_ERROR                 = 621;

    /**
     * MID limits exceeded
     */
    const CONTRACT_LIMIT_EXCEEDED_ERROR                 = 622;

    /**
     * Velocity by unknown card exceeded
     */
    const CARD_VELOCITY_EXCEEDED_ERROR                  = 623;

    /**
     * Ticket size by unknown card exceeded
     */
    const CARD_TICKET_SIZE_EXCEEDED_ERROR               = 624;

    /**
     * User limit exceeded configured limits
     */
    const USER_LIMIT_EXCEEDED_ERROR                     = 625;

    /**
     * Found user transaction declined by issuer
     */
    const MULTIPLE_FAILURE_DETECTION_ERROR              = 626;

    /**
     * CrossSelling Error!
     */
    const CS_DETECTION_ERROR                            = 627;

    /**
     * Amount/count by recurring subscription exceeded
     */
    const RECURRING_LIMIT_EXCEEDED_ERROR                = 628;

    /**
     * Transaction declined by risk management.
     */
    const IRIS_FILTER_DECLINED_ERROR                    = 629;

    /**
     * Transaction on hold, a manual review will be done
     */
    const IRIS_FILTER_ON_HOLD_ERROR                     = 630;

    /**
     * Address Verification failed
     */
    const AVS_ERROR                                     = 690;

    /**
     * MaxMind High Risk Error
     */
    const MAX_MIND_RISK_ERROR                           = 691;

    /**
     * ThreatMetrix High Risk Error
     */
    const THREAT_METRIX_RISK_ERROR                      = 692;

    /**
     * Transaction declined by risk management, IP is NOT whitelisted!
     */
    const IP_NOT_WHITELISTED_ERROR                      = 693;

    /**
     * Transaction declined by risk management, domain is blacklisted!
     */
    const DOMAIN_BLACKLISTED_ERROR                      = 694;

    /**
     * Risk Error: Please contact the risk team!
     */
    const FRAUD_ERROR                                   = 695;

    /**
     * Transaction declined by risk management, iban blacklisted!
     */
    const IBAN_BLACKLIST_ERROR                          = 696;

    /**
     * Consumer with this consumer_id, email combination already exists!
     */
    const CONSUMER_UNIQUENESS_ERROR                     = 701;

    /**
     * Consumer not found!
     */
    const INVALID_CONSUMER_ERROR                        = 702;

    /**
     * Consumer is disabled!
     */
    const DISABLED_CONSUMER_ERROR                       = 703;

    /**
     * General tokenization error.
     */
    const TOKENIZATION_ERROR                            = 700;

    /**
     * Tokenization is not enabled for the merchant or the terminal! Contact support.
     */
    const TOKENIZATION_NOT_ENABLED_ERROR                = 710;

    /**
     * Unsupported token type!
     */
    const INVALID_TOKEN_TYPE_ERROR                      = 720;

    /**
     * Invalid token!
     */
    const INVALID_TOKEN_ERROR                           = 730;

    /**
     * Detokenize action is forbidden!
     */
    const DETOKENIZE_FORBIDDEN_ERROR                    = 740;

    /**
     * General KYC Service Error
     */
    const KYC_SERVICE_ERROR                             = 800;

    /**
     *  Uploaded document MIME type is not supported by KYC provider
     */
    const DOCUMENT_MIME_TYPE_UNSUPPORTED_ERROR          = 801;

    /**
     * Passed attributes are invalid!
     */
    const INVALID_REQUEST_ATTRIBUTES_ERROR              = 802;

    /**
     * KYC Services not configured for Merchant!
     */
    const KYC_SERVICE_NOT_CONFIGURED_ERROR              = 803;

    /**
     * KYC Service provider Error!
     */
    const KYC_SERVICE_PROVIDER_ERROR                    = 804;

    /**
     * Notification already received
     */
    const KYC_SERVICE_NOTIFICATION_ERROR                = 805;

    /**
     * Merchant state does not allow using KYC Service API!
     */
    const KYC_SERVICE_UNACCEPTABLE_MERCHANT_STATE_ERROR = 806;

    /**
     * Some error occurred on the issuer side
     */
    const REMOTE_ERROR                                  = 900;

    /**
     * Some error occurred on the issuer side
     */
    const REMOTE_SYSTEM_ERROR                           = 910;

    /**
     * Issuer configuration error
     */
    const REMOTE_CONFIGURATION_ERROR                    = 920;

    /**
     * Some passed data caused an error on the issuer
     */
    const REMOTE_DATA_ERROR                             = 930;

    /**
     * Remote workflow error
     */
    const REMOTE_WORKFLOW_ERROR                         = 940;

    /**
     * Issuer has time-out with clearing network
     */
    const REMOTE_TIMEOUT_ERROR                          = 950;

    /**
     * Issuer could not reach clearing network
     */
    const REMOTE_CONNECTION_ERROR                       = 960;

    /**
     * Get Genesis Error Code
     *
     * @param $error - error_msg to retrieve error code
     *
     * @return mixed
     */
    public static function getErrorCode($error)
    {
        return constant('\Genesis\API\Constants\Errors::' . $error);
    }

    /**
     * Get detailed description of the provided error code
     *
     * @param int $errorCode
     *
     * @return string
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public static function getErrorDescription($errorCode)
    {
        switch (intval($errorCode)) {
            default:
            case self::ERROR:
                return 'Undefined error.';
            case self::SYSTEM_ERROR:
                return 'A general system error occurred.';
            case self::MAINTENANCE_ERROR:
                return 'System is undergoing maintenance, request could not be handled.';
            case self::AUTHENTICATION_ERROR:
                return 'Login failed. Check your API credentials.';
            case self::CONFIGURATION_ERROR:
                return 'Config error occurred, e.g. terminal not configured properly. Check terminal settings.';
            case self::COMMUNICATION_ERROR:
                return 'Communication with issuer failed, please contact support.';
            case self::CONNECTION_ERROR:
                return 'Connection to issuer could not be established, please contact support.';
            case self::ACCOUNT_ERROR:
                return 'Issuer account data invalid, please contact support.';
            case self::TIMEOUT_ERROR:
                return 'Issuer does not respond within given time-frame - please reconcile.';
            case self::RESPONSE_ERROR:
                return 'Issuer returned invalid response - please reconcile and contact support.';
            case self::PARSING_ERROR:
                return 'Issuer response could not be parsed - please reconcile and contact support.';
            case self::INPUT_DATA_ERROR:
                return 'Invalid data were sent to the API.';
            case self::INVALID_TRANSACTION_TYPE_ERROR:
                return 'Invalid transaction type was passed to API.';
            case self::INPUT_DATA_MISSING_ERROR:
                return 'Required argument is missing.';
            case self::INPUT_DATA_FORMAT_ERROR:
                return 'Argument passed in invalid format.';
            case self::MASTERCARD_FORMAT_ERROR:
                return 'This is a format error stopped by MasterCard due to invalid formatting in certain fields.';
            case self::INPUT_DATA_INVALID_ERROR:
                return 'Argument passed in valid format but makes no sense (e.g. incorrect country code or currency).';
            case self::INVALID_XML_ERROR:
                return 'The input Builder could not be parsed due to invalid code.';
            case self::INVALID_CONTENT_TYPE_ERROR:
                return 'Missing or invalid content type: should be text/xml!';
            case self::WORKFLOW_ERROR:
                return 'A transaction was triggered that is not possible at this time in the workflow,' .
                       'e.g. a refund on a declined transaction.';
            case self::REFERENCE_NOT_FOUND_ERROR:
                return 'Reference transaction was not found.';
            case self::REFERENCE_WORKFLOW_ERROR:
                return 'Wrong Workflow specified.';
            case self::REFERENCE_INVALIDATED_ERROR:
                return 'Reference transaction already invalidated!';
            case self::REFERENCE_MISMATCH_ERROR:
                return 'Data mismatch with reference, e.g. amount exceeds reference.';
            case self::DOUBLE_TRANSACTION_ERROR:
                return 'Transaction doublet was detected, transaction was blocked.';
            case self::TRANSACTION_NOT_FOUND_ERROR:
                return 'The referenced transaction could not be found.';
            case self::CHARGEBACK_NOT_FOUND_ERROR:
                return 'Chargeback not found!';
            case self::RETRIEVAL_REQUEST_NOT_FOUND_ERROR:
                return 'Retrieval Request not found!';
            case self::FRAUD_REPORT_NOT_FOUND_ERROR:
                return 'Fraud Report not found!';
            case self::PROCESSING_ERROR:
                return 'Transaction declined by issuer.';
            case self::INVALID_CARD_ERROR:
                return 'Transaction declined, Credit card number is invalid.';
            case self::ISSUER_OCT_NOT_ENABLED_ERROR:
                return 'OCT not enabled error.';
            case self::EXPIRED_CARD_ERROR:
                return 'Transaction declined, expiration date not in the future or date invalid.';
            case self::TRANSACTION_PENDING_ERROR:
                return 'Transaction pending.';
            case self::CREDIT_EXCEEDED_ERROR:
                return 'Amount exceeds credit card limit.';
            case self::ISSUING_ERROR:
                return 'The voucher could not be issued!';
            case self::RISK_ERROR:
                return 'Transaction declined by risk management.';
            case self::INTERCHANGE_REJECT_ERROR:
                return 'Interchange reject received for transaction!';
            case self::FRONT_END_REJECT_ERROR:
                return 'Transaction declined by frontend reject!';
            case self::BIN_COUNTRY_CHECK_ERROR:
                return 'Card bin does not match billing country.';
            case self::CARD_BLACKLIST_ERROR:
                return 'Card is blacklisted.';
            case self::BIN_BLACKLIST_ERROR:
                return 'BIN blacklisted.';
            case self::COUNTRY_BLACKLIST_ERROR:
                return 'Country blacklisted.';
            case self::IP_BLACKLIST_ERROR:
                return 'IP address blacklisted.';
            case self::BLACKLIST_ERROR:
                return 'Value from the Transaction Request or Risk Parameters is blacklisted.';
            case self::CARD_WHITELIST_ERROR:
                return 'PAN Whitelist Filter blocked the transaction.';
            case self::CARD_LIMIT_EXCEEDED_ERROR:
                return 'Card limit exceeded configured limits.';
            case self::TERMINAL_LIMIT_EXCEEDED_ERROR:
                return 'Terminal limits exceeded.';
            case self::CONTRACT_LIMIT_EXCEEDED_ERROR:
                return 'MID limits exceeded.';
            case self::CARD_VELOCITY_EXCEEDED_ERROR:
                return 'Velocity by unknown card exceeded!';
            case self::CARD_TICKET_SIZE_EXCEEDED_ERROR:
                return 'Ticket size by unknown card exceeded!';
            case self::USER_LIMIT_EXCEEDED_ERROR:
                return 'User limit exceeded configured limits.';
            case self::MULTIPLE_FAILURE_DETECTION_ERROR:
                return 'Found user transaction declined by issuer.';
            case self::CS_DETECTION_ERROR:
                return 'CrossSelling Error!';
            case self::RECURRING_LIMIT_EXCEEDED_ERROR:
                return 'Amount/count by recurring subscription exceeded.';
            case self::IRIS_FILTER_DECLINED_ERROR:
                return 'Transaction declined by risk management.';
            case self::IRIS_FILTER_ON_HOLD_ERROR:
                return 'Transaction on hold, a manual review will be done';
            case self::AVS_ERROR:
                return 'Address Verification failed.';
            case self::MAX_MIND_RISK_ERROR:
                return 'MaxMind High Risk Error.';
            case self::THREAT_METRIX_RISK_ERROR:
                return 'ThreatMetrix High Risk Error.';
            case self::IP_NOT_WHITELISTED_ERROR:
                return 'Transaction declined by risk management, IP is NOT whitelisted!';
            case self::DOMAIN_BLACKLISTED_ERROR:
                return 'Transaction declined by risk management, domain is blacklisted!';
            case self::FRAUD_ERROR:
                return 'Please contact the risk team!';
            case self::IBAN_BLACKLIST_ERROR:
                return 'Transaction declined by risk management, iban blacklisted!';
            case self::REMOTE_ERROR:
                return 'Some error occurred on the issuer.';
            case self::REMOTE_SYSTEM_ERROR:
                return 'Some error occurred on the issuer.';
            case self::REMOTE_CONFIGURATION_ERROR:
                return 'Issuer configuration error.';
            case self::REMOTE_DATA_ERROR:
                return 'Some passed data caused an error on the issuer.';
            case self::REMOTE_WORKFLOW_ERROR:
                return 'Remote workflow error.';
            case self::REMOTE_TIMEOUT_ERROR:
                return 'Issuer has time-out with clearing network.';
            case self::REMOTE_CONNECTION_ERROR:
                return 'Issuer could not reach clearing network.';
            case self::CONSUMER_UNIQUENESS_ERROR:
                return 'Consumer with this consumer_id, email combination already exists!';
            case self::INVALID_CONSUMER_ERROR:
                return 'Consumer not found!';
            case self::DISABLED_CONSUMER_ERROR:
                return 'Consumer is disabled!';
            case self::TOKENIZATION_ERROR:
                return 'General tokenization error.';
            case self::TOKENIZATION_NOT_ENABLED_ERROR:
                return 'Tokenization is not enabled for the merchant or the terminal! Contact support.';
            case self::INVALID_TOKEN_TYPE_ERROR:
                return 'Unsupported token type!';
            case self::INVALID_TOKEN_ERROR:
                return 'Invalid token!';
            case self::DETOKENIZE_FORBIDDEN_ERROR:
                return 'Detokenize action is forbidden!';
            case self::KYC_SERVICE_ERROR:
                return 'General KYC Service Error';
            case self::DOCUMENT_MIME_TYPE_UNSUPPORTED_ERROR:
                return 'Uploaded document MIME type is not supported by KYC provider';
            case self::INVALID_REQUEST_ATTRIBUTES_ERROR:
                return 'Passed attributes are invalid!';
            case self::KYC_SERVICE_NOT_CONFIGURED_ERROR:
                return 'KYC Services not configured for Merchant!';
            case self::KYC_SERVICE_PROVIDER_ERROR:
                return 'KYC Service provider Error!';
            case self::KYC_SERVICE_NOTIFICATION_ERROR:
                return 'Notification already received';
            case self::KYC_SERVICE_UNACCEPTABLE_MERCHANT_STATE_ERROR:
                return 'Merchant state does not allow using KYC Service API!';
        }
    }

    /**
     * Resolve Issuer Response Code
     *
     * @param $issuerResponseCode
     *
     * @return bool|string
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public static function getIssuerResponseCode($issuerResponseCode)
    {
        switch (strval($issuerResponseCode)) {
            case '00':
                return 'Approved or completed successfully';
            case '02':
                return 'Refer to card issue';
            case '03':
                return 'Invalid merchant';
            case '04':
                return 'Pick-up card';
            case '05':
                return 'Do not honour';
            case '06':
                return 'Invalid Transaction for Terminal';
            case '07':
                return 'Honour with ID';
            case '08':
                return 'Time-Out';
            case '09':
                return 'No Original';
            case '10':
                return 'Unable to Reverse';
            case '11':
                return 'Partial Approval';
            case '12':
                return 'Invalid transaction card / issuer / acquirer';
            case '13':
                return 'Invalid amount';
            case '14':
                return 'Invalid card number';
            case '17':
                return 'Invalid Capture date (terminal business date)';
            case '19':
                return 'System Error; Re-enter transaction';
            case '20':
                return 'No From Account';
            case '21':
                return 'No To Account';
            case '22':
                return 'No Checking Account';
            case '23':
                return 'No Saving Account';
            case '24':
                return 'No Credit Account';
            case '30':
                return 'Format error';
            case '34':
                return 'Implausible card data';
            case '39':
                return 'Transaction Not Allowed';
            case '41':
                return 'Pick-up card';
            case '42':
                return 'Special Pickup';
            case '43':
                return 'Hot Card, Pickup (if possible)';
            case '44':
                return 'Pickup Card';
            case '45':
                return 'Transaction Back Off';
            case '51':
                return 'Not sufficient funds';
            case '54':
                return 'Expired card';
            case '55':
                return 'Incorrect PIN; Re-enter';
            case '57':
                return 'Not permitted on card';
            case '58':
                return 'Txn Not Permitted On Term';
            case '61':
                return 'Exceeds amount limit';
            case '62':
                return 'Restricted card';
            case '63':
                return 'MAC Key Error';
            case '65':
                return 'Exceeds frequency limit';
            case '66':
                return 'Exceeds Acquirer Limit';
            case '67':
                return 'Retain Card; no reason specified';
            case '68':
                return 'Response received too late';
            case '75':
                return 'Exceeds PIN Retry';
            case '76':
                return 'Invalid Account';
            case '77':
                return 'Issuer Does Not Participate In The Service';
            case '78':
                return 'Function Not Available';
            case '79':
                return 'Key Validation Error';
            case '80':
                return 'Approval for Purchase Amount Only';
            case '81':
                return 'Unable to Verify PIN';
            case '82':
                return 'Invalid Card Verification Value';
            case '83':
                return 'Not declined (AVS Only)';
            case '84':
                return 'Invalid Life Cycle of transaction';
            case '85':
                return 'No Keys To Use';
            case '86':
                return 'K M E Sync Error';
            case '87':
                return 'PIN Key Error';
            case '88':
                return 'MAC sync Error';
            case '89':
                return 'Security Violation';
            case '91':
                return 'Issuer not available';
            case '92':
                return 'Invalid Issuer';
            case '93':
                return 'Transaction cannot be completed';
            case '94':
                return 'Invalid originator';
            case '96':
                return 'System malfunction';
            case '97':
                return 'No Funds Transfer';
            case '98':
                return 'Duplicate Reversal';
            case '99':
                return 'Duplicate Transaction';
            case 'N3':
                return 'Cash Service Not Available';
            case 'N4':
                return 'Cash Back Request Exceeds Issuer Limit';
            case 'N7':
                return 'CVV2 Failure';
            case 'R0':
                return 'Stop Payment Order';
            case 'R1':
                return 'Revocation of Authorisation Order';
            case 'R3':
                return 'Revocation of all Authorisations Order';
        }

        return false;
    }
}
