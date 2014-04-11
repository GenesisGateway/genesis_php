<?php

namespace Genesis;

class Genesis_Errors extends \Genesis\Genesis_Base
{
    const ERROR                             = 1;

    const SYSTEM_ERROR                      = 100;
    const MAINTENANCE_ERROR                 = 101;
    const AUTHENTICATION_ERROR              = 110;
    const CONFIGURATION_ERROR               = 120;

    const COMMUNICATION_ERROR               = 200;
    const CONNECTION_ERROR                  = 210;
    const ACCOUNT_ERROR                     = 220;
    const TIMEOUT_ERROR                     = 230;
    const RESPONSE_ERROR                    = 240;
    const PARSING_ERROR                     = 250;

    const INPUT_DATA_ERROR                  = 300;
    const INVALID_TRANSACTION_TYPE_ERROR    = 310;
    const INPUT_DATA_MISSING_ERROR          = 320;
    const INPUT_DATA_FORMAT_ERROR           = 330;
    const INPUT_DATA_INVALID_ERROR          = 340;
    const INVALID_XML_ERROR                 = 350;
    const INVALID_CONTENT_TYPE_ERROR        = 360;

    const WORKFLOW_ERROR                    = 400;
    const REFERENCE_NOT_FOUND_ERROR         = 410;
    const REFERENCE_WORKFLOW_ERROR          = 420;
    const REFERENCE_INVALIDATED_ERROR       = 430;
    const REFERENCE_MISMATCH_ERROR          = 440;
    const DOUBLE_TRANSACTION_ERROR          = 450;
    const TRANSACTION_NOT_FOUND_ERROR       = 460;

    const PROCESSING_ERROR                  = 500;
    const INVALID_CARD_ERROR                = 510;
    const EXPIRED_CARD_ERROR                = 520;
    const TRANSACTION_PENDING_ERROR         = 530;
    const CREDIT_EXCEEDED_ERROR             = 540;

    const RISK_ERROR                        = 600;
    const BIN_COUNTRY_CHECK_ERROR           = 609;
    const CARD_BLACKLIST_ERROR              = 610;
    const BIN_BLACKLIST_ERROR               = 611;
    const COUNTRY_BLACKLIST_ERROR           = 612;
    const IP_BLACKLIST_ERROR                = 613;
    const BLACKLIST_ERROR                   = 614;
    const CARD_WHITELIST_ERROR              = 615;
    const CARD_LIMIT_EXCEEDED_ERROR         = 620;
    const TERMINAL_LIMIT_EXCEEDED_ERROR     = 621;
    const CONTRACT_LIMIT_EXCEEDED_ERROR     = 622;
    const CARD_VELOCITY_EXCEEDED_ERROR      = 623;
    const CARD_TICKET_SIZE_EXCEEDED_ERROR   = 624;
    const USER_LIMIT_EXCEEDED_ERROR         = 625;
    const MULTIPLE_FAILURE_DETECTION_ERROR  = 626;
    const CS_DETECTION_ERROR                = 627;
    const RECURRING_LIMIT_EXCEEDED_ERROR    = 628;
    const AVS_ERROR                         = 690;
    const MAX_MIND_RISK_ERROR               = 691;
    const THREAT_METRIX_RISK_ERROR          = 692;

    const REMOTE_ERROR                      = 900;
    const REMOTE_SYSTEM_ERROR               = 910;
    const REMOTE_CONFIGURATION_ERROR        = 920;
    const REMOTE_DATA_ERROR                 = 930;
    const REMOTE_WORKFLOW_ERROR             = 940;
    const REMOTE_TIMEOUT_ERROR              = 950;
    const REMOTE_CONNECTION_ERROR           = 960;

    /**
     * Get detailed description of the provided error code
     *
     * @param int $Error_Code
     * @return string
     */
    static function getErrorDescription($Error_Code = 0)
    {
        switch ($Error_Code)
        {
            case 1:
                return "Undefined error.";
            case 100:
                return "A general system error occurred.";
            case 101:
                return "System is undergoing maintenance, request could not be handled.";
            case 110:
                return "Login failed. Check your API credentials.";
            case 120:
                return "Configuration error occurred, e.g. terminal not configured properly. Check terminal settings.";
            case 200:
                return "Communication with issuer failed, please contact support.";
            case 210:
                return "Connection to issuer could not be established, please contact support.";
            case 220:
                return "Issuer account data invalid, please contact support.";
            case 230:
                return "Issuer does not respond within given time-frame - please reconcile.";
            case 240:
                return "Issuer returned invalid response - please reconcile and contact support.";
            case 250:
                return "Issuer response could not be parsed - please reconcile and contact support.";
            case 300:
                return "Invalid were data sent to the API.";
            case 310:
                return "Invalid transaction type was passed to API.";
            case 320:
                return "Required argument is missing.";
            case 330:
                return "Argument passed in invalid format.";
            case 340:
                return "Argument passed in valid format but makes no sense (e.g. incorrect country code or currency).";
            case 350:
                return "The input XML could not be parsed due to invalid code.";
            case 400:
                return "A transaction was triggered that is not possible at this time in the workflow, e.g. a refund on a declined transaction.";
            case 410:
                return "Reference transaction was not found.";
            case 420:
                return "Wrong Workflow specified.";
            case 430:
                return "Reference transaction already invalidated!";
            case 440:
                return "Data mismatch with reference, e.g. amount exceeds reference.";
            case 450:
                return "Transaction doublet was detected, transaction was blocked.";
            case 460:
                return "The referenced transaction could not be found.";
            case 500:
                return "Transaction declined by issuer.";
            case 510:
                return "Transaction declined, Credit card number is invalid.";
            case 520:
                return "Transaction declined, expiration date not in the future or date invalid.";
            case 530:
                return "Transaction pending.";
            case 540:
                return "Amount exceeds credit card limit.";
            case 600:
                return "Transaction declined by risk management.";
            case 609:
                return "Card bin does not match billing country.";
            case 610:
                return "Card is blacklisted.";
            case 611:
                return "BIN blacklisted.";
            case 612:
                return "Country blacklisted.";
            case 613:
                return "IP address blacklisted.";
            case 614:
                return "Value from the Transaction Request or Risk Parameters is blacklisted.";
            case 616:
                return "PAN Whitelist Filter blocked the transaction.";
            case 620:
                return "Card limit exceeded configured limits.";
            case 621:
                return "Terminal limits exceeded.";
            case 622:
                return "MID limits exceeded.";
            case 623:
                return "Velocity by unknown card exceeded!";
            case 624:
                return "Ticket size by unknown card exceeded!";
            case 625:
                return "User limit exceeded configured limits.";
            case 626:
                return "Found user transaction declined by issuer.";
            case 627:
                return "CrossSelling Error!";
            case 628:
                return "Amount/count by recurring subscription exceeded.";
            case 629:
                return "Address Verification failed.";
            case 691:
                return "MaxMind High Risk Error.";
            case 692:
                return "ThreatMetrix High Risk Error.";
            case 900:
                return "Some error occurred on the issuer.";
            case 910:
                return "Some error occurred on the issuer.";
            case 920:
                return "Issuer configuration error.";
            case 930:
                return "Some passed data caused an error on the issuer.";
            case 940:
                return "Remote workflow error.";
            case 950:
                return "Issuer has time-out with clearing network.";
            case 960:
                return "Issuer could not reach clearing network.";
        }
    }
}