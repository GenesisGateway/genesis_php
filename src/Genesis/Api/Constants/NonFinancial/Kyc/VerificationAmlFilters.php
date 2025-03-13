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
 * @copyright   Copyright (C) 2015-2025 emerchantpay Ltd.
 * @license     http://opensource.org/licenses/MIT The MIT License
 */

namespace Genesis\Api\Constants\NonFinancial\Kyc;

use Genesis\Utils\Common;

/**
 * Class VerificationAmlFilters
 *
 * @package Genesis\Api\Constants\NonFinancial\Kyc
 */
class VerificationAmlFilters
{
    const FILTERS_SANCTION                              = 'sanction';
    const FILTERS_WARNING                               = 'warning';
    const FILTERS_FITNESS_PROBITY                       = 'fitness-probity';
    const FILTERS_PEP                                   = 'pep';
    const FILTERS_PEP_CLASS_1                           = 'pep-class-1';
    const FILTERS_PEP_CLASS_2                           = 'pep-class-2';
    const FILTERS_PEP_CLASS_3                           = 'pep-class-3';
    const FILTERS_PEP_CLASS_4                           = 'pep-class-4';
    const FILTERS_ADVERSE_MEDIA                         = 'adverse-media';
    const FILTERS_ADVERSE_MEDIA_GENERAL                 = 'adverse-media-general';
    const FILTERS_ADVERSE_MEDIA_NARCOTICS               = 'adverse-media-narcotics';
    const FILTERS_ADVERSE_MEDIA_FRAUD                   = 'adverse-media-fraud';
    const FILTERS_ADVERSE_MEDIA_TERRORISM               = 'adverse-media-terrorism';
    const FILTERS_ADVERSE_MEDIA_SEXUAL_CRIME            = 'adverse-media-sexual-crime';
    const FILTERS_ADVERSE_MEDIA_VIOLENT_CRIME           = 'adverse-media-violent-crime';
    const FILTERS_ADVERSE_MEDIA_FINANCIAL_CRIME         = 'adverse-media-financial-crime';
    const FILTERS_ADVERSE_MEDIA_V2_OTHER_MINOR          = 'adverse-media-v2-other-minor';
    const FILTERS_ADVERSE_MEDIA_V2_OTHER_SERIOUS        = 'adverse-media-v2-other-serious';
    const FILTERS_ADVERSE_MEDIA_V2_OTHER_FINANCIAL      = 'adverse-media-v2-other-financial';
    const FILTERS_ADVERSE_MEDIA_V2_VIOLENCE_NON_AML_CFT = 'adverse-media-v2-violence-non-aml-cft';
    const FILTERS_ADVERSE_MEDIA_V2_FINANCIAL_DIFFICULTY = 'adverse-media-v2-financial-difficulty';
    const FILTERS_ADVERSE_MEDIA_V2_REGULATORY           = 'adverse-media-v2-regulatory';
    const FILTERS_ADVERSE_MEDIA_V2_GENERAL_AML_CFT      = 'adverse-media-v2-general-aml-cft';
    const FILTERS_ADVERSE_MEDIA_V2_CYBERCRIME           = 'adverse-media-v2-cybercrime';
    const FILTERS_ADVERSE_MEDIA_V2_TERRORISM            = 'adverse-media-v2-terrorism';
    const FILTERS_ADVERSE_MEDIA_V2_VIOLENCE_AML_CFT     = 'adverse-media-v2-violence-aml-cft';
    const FILTERS_ADVERSE_MEDIA_V2_NARCOTICS_AML_CFT    = 'adverse-media-v2-narcotics-aml-cft';
    const FILTERS_ADVERSE_MEDIA_V2_FRAUD_LINKED         = 'adverse-media-v2-fraud-linked';
    const FILTERS_ADVERSE_MEDIA_V2_FINANCIAL_AML_CFT    = 'adverse-media-v2-financial-aml-cft';
    const FILTERS_ADVERSE_MEDIA_V2_PROPERTY             = 'adverse-media-v2-property';

    /**
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(self::class);
    }
}
