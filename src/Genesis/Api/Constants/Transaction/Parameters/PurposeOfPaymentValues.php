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
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @author      emerchantpay
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Constants\Transaction\Parameters;

use Genesis\Utils\Common;

/**
 * Human-readable Purpose of Payment values
 *
 * Class PurposeOfPaymentValues
 *
 * @package Genesis\Api\Constants\Transaction\Parameters
 */
class PurposeOfPaymentValues
{
    /** Account management */
    const ACCOUNT_MANAGEMENT = 'account_management';
    /** Air transport related business */
    const AIR_TRANSPORT_RELATED_BUSINESS = 'air_transport_related_business';
    /** Transaction is the payment of allowance */
    const PAYMENT_OF_ALLOWANCE = 'payment_of_allowance';
    /** Settlement of annuity */
    const SETTLEMENT_OF_ANNUITY = 'settlement_of_annuity';
    /** Unemployment disability benefit */
    const UNEMPLOYMENT_DISABILITY_BENEFIT = 'unemployment_disability_benefit';
    /** Business expenses */
    const BUSINESS_EXPENSES = 'business_expenses';
    /** Bonus payment */
    const BONUS_PAYMENT = 'bonus_payment';
    /** Bus transport related business */
    const BUS_TRANSPORT_RELATED_BUSINESS = 'bus_transport_related_business';
    /** Cash management transfer */
    const CASH_MANAGEMENT_TRANSFER = 'cash_management_transfer';
    /** Payment of cable TV bill */
    const PAYMENT_OF_CABLE_TV_BILL = 'payment_of_cable_tv_bill';
    /** Government institute issued related to cash compensation, helplessness, disability */
    const GOVERNMENT_INSTITUTE_ISSUED_RELATED_TO_CASH_COMPENSATION_HELPLESSNESS_DISABILITY =
        'government_institute_issued_related_to_cash_compensation_helplessness_disability';
    /** Credit card payment */
    const CREDIT_CARD_PAYMENT = 'credit_card_payment';
    /** Payment of credit card bill */
    const PAYMENT_OF_CREDIT_CARD_BILL = 'payment_of_credit_card_bill';
    /** Payment for charity reasons */
    const PAYMENT_FOR_CHARITY_REASONS = 'payment_for_charity_reasons';
    /** Collection payment */
    const COLLECTION_PAYMENT = 'collection_payment';
    /** Commercial payment */
    const COMMERCIAL_PAYMENT = 'commercial_payment';
    /** Commission */
    const COMMISSION = 'commission';
    /** Compensation relating to interest loss/value date adjustment and can include fees */
    const COMPENSATION_RELATING_TO_INTEREST_LOSS_VALUE_DATE_ADJUSTMENT_AND_CAN_INCLUDE_FEES =
        'compensation_relating_to_interest_loss_value_date_adjustment_and_can_include_fees';
    /** Payment of copyright */
    const PAYMENT_OF_COPYRIGHT = 'payment_of_copyright';
    /** Related to a debit card payment */
    const RELATED_TO_DEBIT_CARD_PAYMENT = 'related_to_debit_card_payment';
    /** Payment of a deposit */
    const PAYMENT_OF_DEPOSIT = 'payment_of_deposit';
    /** Payment of dividend */
    const PAYMENT_OF_DIVIDEND = 'payment_of_dividend';
    /** Payment of study/tuition fees */
    const PAYMENT_OF_STUDY_TUITION_FEES = 'payment_of_study_tuition_fees';
    /** Education */
    const EDUCATION = 'education';
    /** Payment of electricity bill */
    const PAYMENT_OF_ELECTRICITY_BILL = 'payment_of_electricity_bill';
    /** Energies */
    const ENERGIES = 'energies';
    /** General fees */
    const GENERAL_FEES = 'general_fees';
    /** Payment for ferry related business */
    const PAYMENT_FOR_FERRY_RELATED_BUSINESS = 'payment_for_ferry_related_business';
    /** Foreign exchange */
    const FOREIGN_EXCHANGE = 'foreign_exchange';
    /** Payment of gas bill */
    const PAYMENT_OF_GAS_BILL = 'payment_of_gas_bill';
    /** Compensation to unemployed persons during insolvency procedures */
    const COMPENSATION_TO_UNEMPLOYED_PERSONS_DURING_INSOLVENCY_PROCEDURES =
        'compensation_to_unemployed_persons_during_insolvency_procedures';
    /** Government payment */
    const GOVERNMENT_PAYMENT = 'government_payment';
    /** Health insurance */
    const HEALTH_INSURANCE = 'health_insurance';
    /** Reimbursement of credit card payment */
    const REIMBURSEMENT_OF_CREDIT_CARD_PAYMENT = 'reimbursement_of_credit_card_payment';
    /** Reimbursement of debit card payment */
    const REIMBURSEMENT_OF_DEBIT_CARD_PAYMENT = 'reimbursement_of_debit_card_payment';
    /** Payment of car insurance premium */
    const PAYMENT_OF_CAR_INSURANCE_PREMIUM = 'payment_of_car_insurance_premium';
    /** Transaction is related to the payment of an insurance claim */
    const TRANSACTION_RELATED_TO_PAYMENT_OF_INSURANCE_CLAIM =
        'transaction_related_to_payment_of_insurance_claim';
    /** Installment */
    const INSTALLMENT = 'installment';
    /** Insurance premium */
    const INSURANCE_PREMIUM = 'insurance_premium';
    /** Payment of mutual funds, investment products and shares */
    const PAYMENT_OF_MUTUAL_FUNDS_INVESTMENT_PRODUCTS_AND_SHARES =
        'payment_of_mutual_funds_investment_products_and_shares';
    /** Intra company payment */
    const INTRA_COMPANY_PAYMENT = 'intra_company_payment';
    /** Interest */
    const INTEREST = 'interest';
    /** Income tax */
    const INCOME_TAX = 'income_tax';
    /** Investment */
    const INVESTMENT = 'investment';
    /** Labor insurance */
    const LABOR_INSURANCE = 'labor_insurance';
    /** License fee */
    const LICENSE_FEE = 'license_fee';
    /** Life insurance */
    const LIFE_INSURANCE = 'life_insurance';
    /** Loan */
    const LOAN = 'loan';
    /** Medical services */
    const MEDICAL_SERVICES = 'medical_services';
    /** Mobile P2B payment */
    const MOBILE_P2B_PAYMENT = 'mobile_p2b_payment';
    /** Mobile P2P payment */
    const MOBILE_P2P_PAYMENT = 'mobile_p2p_payment';
    /** Mobile top up */
    const MOBILE_TOP_UP = 'mobile_top_up';
    /** Not otherwise specified */
    const NOT_OTHERWISE_SPECIFIED = 'not_otherwise_specified';
    /** Other */
    const OTHER = 'other';
    /** Transaction is related to a payment of other telecom related bill */
    const TRANSACTION_RELATED_TO_PAYMENT_OF_OTHER_TELECOM_RELATED_BILL =
        'transaction_related_to_payment_of_other_telecom_related_bill';
    /** Payroll */
    const PAYROLL = 'payroll';
    /** Contribution to pension fund */
    const CONTRIBUTION_TO_PENSION_FUND = 'contribution_to_pension_fund';
    /** Pension payment */
    const PENSION_PAYMENT = 'pension_payment';
    /** Payment of telephone bill */
    const PAYMENT_OF_TELEPHONE_BILL = 'payment_of_telephone_bill';
    /** Property insurance */
    const PROPERTY_INSURANCE = 'property_insurance';
    /** Transaction is for general rental/lease */
    const TRANSACTION_FOR_GENERAL_RENTAL_LEASE = 'transaction_for_general_rental_lease';
    /** The payment of rent */
    const THE_PAYMENT_OF_RENT = 'the_payment_of_rent';
    /** Payment for railway transport related business */
    const PAYMENT_FOR_RAILWAY_TRANSPORT_RELATED_BUSINESS =
        'payment_for_railway_transport_related_business';
    /** Royalties */
    const ROYALTIES = 'royalties';
    /** Salary payment */
    const SALARY_PAYMENT = 'salary_payment';
    /** Payment to savings/retirement account */
    const PAYMENT_TO_SAVINGS_RETIREMENT_ACCOUNT = 'payment_to_savings_retirement_account';
    /** Securities */
    const SECURITIES = 'securities';
    /** Social security benefit */
    const SOCIAL_SECURITY_BENEFIT = 'social_security_benefit';
    /** Study */
    const STUDY = 'study';
    /** Subscription */
    const SUBSCRIPTION = 'subscription';
    /** Supplier payment */
    const SUPPLIER_PAYMENT = 'supplier_payment';
    /** Refund of a tax payment or obligation */
    const REFUND_OF_TAX_PAYMENT_OR_OBLIGATION = 'refund_of_tax_payment_or_obligation';
    /** Tax payment */
    const TAX_PAYMENT = 'tax_payment';
    /** Transaction is related to a payment of telecommunications related bill */
    const TRANSACTION_RELATED_TO_PAYMENT_OF_TELECOMMUNICATIONS_RELATED_BILL =
        'transaction_related_to_payment_of_telecommunications_related_bill';
    /** Trade services operation */
    const TRADE_SERVICES_OPERATION = 'trade_services_operation';
    /** Treasury payment */
    const TREASURY_PAYMENT = 'treasury_payment';
    /** Payment for travel */
    const PAYMENT_FOR_TRAVEL = 'payment_for_travel';
    /** Utility bill payment */
    const UTILITY_BILL_PAYMENT = 'utility_bill_payment';
    /** Value added tax payment */
    const VALUE_ADDED_TAX_PAYMENT = 'value_added_tax_payment';
    /** Withholding */
    const WITHHOLDING = 'withholding';
    /** Payment of water bill */
    const PAYMENT_OF_WATER_BILL = 'payment_of_water_bill';

    /**
     * Get all human-readable Purpose of Payment values.
     *
     * @return array Indexed list of the 81 values
     */
    public static function getAll()
    {
        return array_values(Common::getClassConstants(self::class));
    }

    /**
     * Get the Visa code associated with each human-readable value.
     *
     * @return array Human-readable value => Visa code
     */
    public static function getValueToCodeMap()
    {
        return [
            self::ACCOUNT_MANAGEMENT => PurposeOfPayment::ISACCT,
            self::AIR_TRANSPORT_RELATED_BUSINESS => PurposeOfPayment::ISAIRB,
            self::PAYMENT_OF_ALLOWANCE => PurposeOfPayment::ISALLW,
            self::SETTLEMENT_OF_ANNUITY => PurposeOfPayment::ISANNI,
            self::UNEMPLOYMENT_DISABILITY_BENEFIT => PurposeOfPayment::ISBENE,
            self::BUSINESS_EXPENSES => PurposeOfPayment::ISBEXP,
            self::BONUS_PAYMENT => PurposeOfPayment::ISBONU,
            self::BUS_TRANSPORT_RELATED_BUSINESS => PurposeOfPayment::ISBUSB,
            self::CASH_MANAGEMENT_TRANSFER => PurposeOfPayment::ISCASH,
            self::PAYMENT_OF_CABLE_TV_BILL => PurposeOfPayment::ISCBTV,
            self::GOVERNMENT_INSTITUTE_ISSUED_RELATED_TO_CASH_COMPENSATION_HELPLESSNESS_DISABILITY =>
                PurposeOfPayment::ISCCHD,
            self::CREDIT_CARD_PAYMENT => PurposeOfPayment::ISCCRD,
            self::PAYMENT_OF_CREDIT_CARD_BILL => PurposeOfPayment::ISCDBL,
            self::PAYMENT_FOR_CHARITY_REASONS => PurposeOfPayment::ISCHAR,
            self::COLLECTION_PAYMENT => PurposeOfPayment::ISCOLL,
            self::COMMERCIAL_PAYMENT => PurposeOfPayment::ISCOMC,
            self::COMMISSION => PurposeOfPayment::ISCOMM,
            self::COMPENSATION_RELATING_TO_INTEREST_LOSS_VALUE_DATE_ADJUSTMENT_AND_CAN_INCLUDE_FEES =>
                PurposeOfPayment::ISCOMP,
            self::PAYMENT_OF_COPYRIGHT => PurposeOfPayment::ISCPYR,
            self::RELATED_TO_DEBIT_CARD_PAYMENT => PurposeOfPayment::ISDCRD,
            self::PAYMENT_OF_DEPOSIT => PurposeOfPayment::ISDEPT,
            self::PAYMENT_OF_DIVIDEND => PurposeOfPayment::ISDIVD,
            self::PAYMENT_OF_STUDY_TUITION_FEES => PurposeOfPayment::ISEDUE,
            self::EDUCATION => PurposeOfPayment::ISEDUE,
            self::PAYMENT_OF_ELECTRICITY_BILL => PurposeOfPayment::ISELEC,
            self::ENERGIES => PurposeOfPayment::ISENRG,
            self::GENERAL_FEES => PurposeOfPayment::ISFEES,
            self::PAYMENT_FOR_FERRY_RELATED_BUSINESS => PurposeOfPayment::ISFERB,
            self::FOREIGN_EXCHANGE => PurposeOfPayment::ISFREX,
            self::PAYMENT_OF_GAS_BILL => PurposeOfPayment::ISGASB,
            self::COMPENSATION_TO_UNEMPLOYED_PERSONS_DURING_INSOLVENCY_PROCEDURES =>
                PurposeOfPayment::ISGFRP,
            self::GOVERNMENT_PAYMENT => PurposeOfPayment::ISGOVT,
            self::HEALTH_INSURANCE => PurposeOfPayment::ISHLTI,
            self::REIMBURSEMENT_OF_CREDIT_CARD_PAYMENT => PurposeOfPayment::ISICCP,
            self::REIMBURSEMENT_OF_DEBIT_CARD_PAYMENT => PurposeOfPayment::ISIDCP,
            self::PAYMENT_OF_CAR_INSURANCE_PREMIUM => PurposeOfPayment::ISINPC,
            self::TRANSACTION_RELATED_TO_PAYMENT_OF_INSURANCE_CLAIM =>
                PurposeOfPayment::ISINSC,
            self::INSTALLMENT => PurposeOfPayment::ISINSM,
            self::INSURANCE_PREMIUM => PurposeOfPayment::ISINSU,
            self::PAYMENT_OF_MUTUAL_FUNDS_INVESTMENT_PRODUCTS_AND_SHARES => PurposeOfPayment::ISINVS,
            self::INTRA_COMPANY_PAYMENT => PurposeOfPayment::ISINTC,
            self::INTEREST => PurposeOfPayment::ISINTE,
            self::INCOME_TAX => PurposeOfPayment::ISINTX,
            self::INVESTMENT => PurposeOfPayment::ISINVS,
            self::LABOR_INSURANCE => PurposeOfPayment::ISLBRI,
            self::LICENSE_FEE => PurposeOfPayment::ISLICF,
            self::LIFE_INSURANCE => PurposeOfPayment::ISLIFI,
            self::LOAN => PurposeOfPayment::ISLOAN,
            self::MEDICAL_SERVICES => PurposeOfPayment::ISMDCS,
            self::MOBILE_P2B_PAYMENT => PurposeOfPayment::ISMP2B,
            self::MOBILE_P2P_PAYMENT => PurposeOfPayment::ISMP2P,
            self::MOBILE_TOP_UP => PurposeOfPayment::ISMTUP,
            self::NOT_OTHERWISE_SPECIFIED => PurposeOfPayment::ISNOWS,
            self::OTHER => PurposeOfPayment::ISOTHR,
            self::TRANSACTION_RELATED_TO_PAYMENT_OF_OTHER_TELECOM_RELATED_BILL => PurposeOfPayment::ISOTLC,
            self::PAYROLL => PurposeOfPayment::ISPAYR,
            self::CONTRIBUTION_TO_PENSION_FUND => PurposeOfPayment::ISPEFC,
            self::PENSION_PAYMENT => PurposeOfPayment::ISPENS,
            self::PAYMENT_OF_TELEPHONE_BILL => PurposeOfPayment::ISPHON,
            self::PROPERTY_INSURANCE => PurposeOfPayment::ISPPTI,
            self::TRANSACTION_FOR_GENERAL_RENTAL_LEASE => PurposeOfPayment::ISRELG,
            self::THE_PAYMENT_OF_RENT => PurposeOfPayment::ISRENT,
            self::PAYMENT_FOR_RAILWAY_TRANSPORT_RELATED_BUSINESS => PurposeOfPayment::ISRLWY,
            self::ROYALTIES => PurposeOfPayment::ISROYA,
            self::SALARY_PAYMENT => PurposeOfPayment::ISSALA,
            self::PAYMENT_TO_SAVINGS_RETIREMENT_ACCOUNT => PurposeOfPayment::ISSAVG,
            self::SECURITIES => PurposeOfPayment::ISSECU,
            self::SOCIAL_SECURITY_BENEFIT => PurposeOfPayment::ISSSBE,
            self::STUDY => PurposeOfPayment::ISSTDY,
            self::SUBSCRIPTION => PurposeOfPayment::ISSUBS,
            self::SUPPLIER_PAYMENT => PurposeOfPayment::ISSUPP,
            self::REFUND_OF_TAX_PAYMENT_OR_OBLIGATION => PurposeOfPayment::ISTAXR,
            self::TAX_PAYMENT => PurposeOfPayment::ISTAXS,
            self::TRANSACTION_RELATED_TO_PAYMENT_OF_TELECOMMUNICATIONS_RELATED_BILL => PurposeOfPayment::ISTBIL,
            self::TRADE_SERVICES_OPERATION => PurposeOfPayment::ISTRAD,
            self::TREASURY_PAYMENT => PurposeOfPayment::ISTREA,
            self::PAYMENT_FOR_TRAVEL => PurposeOfPayment::ISTRPT,
            self::UTILITY_BILL_PAYMENT => PurposeOfPayment::ISUBIL,
            self::VALUE_ADDED_TAX_PAYMENT => PurposeOfPayment::ISVATX,
            self::WITHHOLDING => PurposeOfPayment::ISWHLD,
            self::PAYMENT_OF_WATER_BILL => PurposeOfPayment::ISWTER,
        ];
    }
}
