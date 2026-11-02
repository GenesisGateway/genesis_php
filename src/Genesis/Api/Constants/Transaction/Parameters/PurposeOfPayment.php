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
 * @copyright   Copyright (C) 2015-2026 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Constants\Transaction\Parameters;

use Genesis\Utils\Common;

/**
 * Purpose of payment
 *
 * Class PurposeOfPayment
 *
 * @package Genesis\Api\Constants\Transaction\Parameters
 */
class PurposeOfPayment
{
    /**
     * Account management
     */
    const ISACCT = 'ISACCT';

    /**
     * Air transport related business
     */
    const ISAIRB = 'ISAIRB';

    /**
     * Transaction is the payment of allowance
     */
    const ISALLW = 'ISALLW';

    /**
     * Settlement of annuity
     */
    const ISANNI = 'ISANNI';

    /**
     * Unemployment disability benefit
     */
    const ISBENE = 'ISBENE';

    /**
     * Business expenses
     */
    const ISBEXP = 'ISBEXP';

    /**
     * Bonus payment
     */
    const ISBONU = 'ISBONU';

    /**
     * Bus transport related business
     */
    const ISBUSB = 'ISBUSB';

    /**
     * Cash management transfer
     */
    const ISCASH = 'ISCASH';

    /**
     * Payment of cable TV bill
     */
    const ISCBTV = 'ISCBTV';

    /**
     * Government institute issued related to cash compensation, helplessness, disability
     */
    const ISCCHD = 'ISCCHD';

    /**
     * Credit card payment
     */
    const ISCCRD = 'ISCCRD';

    /**
     * Payment of credit card bill
     */
    const ISCDBL = 'ISCDBL';

    /**
     * Payment for charity reasons
     */
    const ISCHAR = 'ISCHAR';

    /**
     * Collection payment
     */
    const ISCOLL = 'ISCOLL';

    /**
     * Commercial payment
     */
    const ISCOMC = 'ISCOMC';

    /**
     * Commission
     */
    const ISCOMM = 'ISCOMM';

    /**
     * Compensation relating to interest loss/value date adjustment and can include fees
     */
    const ISCOMP = 'ISCOMP';

    /**
     * Payment of copyright
     */
    const ISCPYR = 'ISCPYR';

    /**
     * Related to a debit card payment
     */
    const ISDCRD = 'ISDCRD';

    /**
     * Payment of a deposit
     */
    const ISDEPT = 'ISDEPT';

    /**
     * Payment of dividend
     */
    const ISDIVD = 'ISDIVD';

    /**
     * Payment of study/tuition fees
     */
    const ISEDUE = 'ISEDUE';

    /**
     * Payment of electricity bill
     */
    const ISELEC = 'ISELEC';

    /**
     * Energies
     */
    const ISENRG = 'ISENRG';

    /**
     * General fees
     */
    const ISFEES = 'ISFEES';

    /**
     * Payment for ferry related business
     */
    const ISFERB = 'ISFERB';

    /**
     * Foreign exchange
     */
    const ISFREX = 'ISFREX';

    /**
     * Payment of gas bill
     */
    const ISGASB = 'ISGASB';

    /**
     * Compensation to unemployed persons during insolvency procedures
     */
    const ISGFRP = 'ISGFRP';

    /**
     * Government payment
     */
    const ISGOVT = 'ISGOVT';

    /**
     * Health insurance
     */
    const ISHLTI = 'ISHLTI';

    /**
     * Reimbursement of credit card payment
     */
    const ISICCP = 'ISICCP';

    /**
     * Reimbursement of debit card payment
     */
    const ISIDCP = 'ISIDCP';

    /**
     * Payment of car insurance premium
     */
    const ISINPC = 'ISINPC';

    /**
     * Transaction is related to the payment of an insurance claim
     */
    const ISINSC = 'ISINSC';

    /**
     * Installment
     */
    const ISINSM = 'ISINSM';

    /**
     * Insurance premium
     */
    const ISINSU = 'ISINSU';

    /**
     * Intra company payment
     */
    const ISINTC = 'ISINTC';

    /**
     * Interest
     */
    const ISINTE = 'ISINTE';

    /**
     * Income tax
     */
    const ISINTX = 'ISINTX';

    /**
     * Investment
     */
    const ISINVS = 'ISINVS';

    /**
     * Labor insurance
     */
    const ISLBRI = 'ISLBRI';

    /**
     * License fee
     */
    const ISLICF = 'ISLICF';

    /**
     * Life insurance
     */
    const ISLIFI = 'ISLIFI';

    /**
     * Loan
     */
    const ISLOAN = 'ISLOAN';

    /**
     * Medical services
     */
    const ISMDCS = 'ISMDCS';

    /**
     * Mobile P2B payment
     */
    const ISMP2B = 'ISMP2B';

    /**
     * Mobile P2P payment
     */
    const ISMP2P = 'ISMP2P';

    /**
     * Mobile top up
     */
    const ISMTUP = 'ISMTUP';

    /**
     * Not otherwise specified
     */
    const ISNOWS = 'ISNOWS';

    /**
     * Other
     */
    const ISOTHR = 'ISOTHR';

    /**
     * Transaction is related to a payment of other telecom related bill
     */
    const ISOTLC = 'ISOTLC';

    /**
     * Payroll
     */
    const ISPAYR = 'ISPAYR';

    /**
     * Contribution to pension fund
     */
    const ISPEFC = 'ISPEFC';

    /**
     * Pension payment
     */
    const ISPENS = 'ISPENS';

    /**
     * Payment of telephone bill
     */
    const ISPHON = 'ISPHON';

    /**
     * Property insurance
     */
    const ISPPTI = 'ISPPTI';

    /**
     * Transaction is for general rental/lease
     */
    const ISRELG = 'ISRELG';

    /**
     * The payment of rent
     */
    const ISRENT = 'ISRENT';

    /**
     * Payment for railway transport related business
     */
    const ISRLWY = 'ISRLWY';

    /**
     * Royalties
     */
    const ISROYA = 'ISROYA';

    /**
     * Salary payment
     */
    const ISSALA = 'ISSALA';

    /**
     * Payment to savings/retirement account
     */
    const ISSAVG = 'ISSAVG';

    /**
     * Securities
     */
    const ISSECU = 'ISSECU';

    /**
     * Social security benefit
     */
    const ISSSBE = 'ISSSBE';

    /**
     * Study
     */
    const ISSTDY = 'ISSTDY';

    /**
     * Subscription
     */
    const ISSUBS = 'ISSUBS';

    /**
     * Supplier payment
     */
    const ISSUPP = 'ISSUPP';

    /**
     * Refund of a tax payment or obligation
     */
    const ISTAXR = 'ISTAXR';

    /**
     * Tax payment
     */
    const ISTAXS = 'ISTAXS';

    /**
     * Transaction is related to a payment of telecommunications related bill
     */
    const ISTBIL = 'ISTBIL';

    /**
     * Trade services operation
     */
    const ISTRAD = 'ISTRAD';

    /**
     * Treasury payment
     */
    const ISTREA = 'ISTREA';

    /**
     * Payment for travel
     */
    const ISTRPT = 'ISTRPT';

    /**
     * Utility bill payment
     */
    const ISUBIL = 'ISUBIL';

    /**
     * Value added tax payment
     */
    const ISVATX = 'ISVATX';

    /**
     * Withholding
     */
    const ISWHLD = 'ISWHLD';

    /**
     * Payment of water bill
     */
    const ISWTER = 'ISWTER';

    /**
     * Get All Purpose of Payment Constants
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }

    /**
     * Get all Purpose of Payment codes
     *
     * @return array
     */
    public static function getCodes()
    {
        return array_values(self::getAll());
    }
}
