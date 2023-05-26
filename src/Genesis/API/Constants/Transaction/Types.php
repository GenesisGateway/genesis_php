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
namespace Genesis\API\Constants\Transaction;

use Genesis\API\Constants\NonFinancial\Services;
use Genesis\Utils\Common;

/**
 * Class Types
 *
 * Transaction types of a Genesis Transaction
 *
 * @package Genesis\API\Constants\Transaction
 */
class Types
{
    /**
     * Account Verification
     *
     * @deprecated Since 1.21.9 Payment method is deprecated and will be removed
     */
    const ACCOUNT_VERIFICATION = 'account_verification';

    /**
     * A standard Authorization
     */
    const AUTHORIZE = 'authorize';

    /**
     * 3D-Secure Authorization
     */
    const AUTHORIZE_3D = 'authorize3d';

    /**
     * A standard Sale
     */
    const SALE = 'sale';

    /**
     * 3D-Secure Sale
     */
    const SALE_3D = 'sale3d';

    /**
     * Capture settles a transaction which has been authorized before.
     */
    const CAPTURE = 'capture';

    /**
     * Refunds allow to return already billed amounts to customers.
     */
    const REFUND = 'refund';

    /**
     * Void transactions undo previous transactions.
     */
    const VOID = 'void';

    /**
     * Credits (also known as Credit Fund Transfer a.k.a. CFT)
     */
    const CREDIT = 'credit';

    /**
     * Payouts transactions
     */
    const PAYOUT = 'payout';

    /**
     * A standard initial recurring
     * @deprecated Since 1.21.5 Payment method is deprecated and will be removed
     */
    const INIT_RECURRING_SALE = 'init_recurring_sale';

    /**
     * 3D-based initial recurring
     * @deprecated Since 1.21.5 Payment method is deprecated and will be removed
     */
    const INIT_RECURRING_SALE_3D = 'init_recurring_sale3d';

    /**
     * A RecurringSale transaction is a "repeated" transaction which follows and references an initial transaction
     * @deprecated Since 1.21.5 Payment method is deprecated and will be removed
     */
    const RECURRING_SALE = 'recurring_sale';

    /**
     * Bank transfer, popular in Netherlands (via ABN)
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const ABNIDEAL = 'abn_ideal';

    /**
     * Voucher-based payment
     */
    const CASHU = 'cashu';

    /**
     * Wallet-based payment
     */
    const EZEEWALLET = 'ezeewallet';

    /**
     * Neteller
     */
    const NETELLER = 'neteller';

    /**
     * POLi is Australia's most popular online real time debit payment system.
     */
    const POLI = 'poli';

    /**
     * WebMoney is a global settlement system and environment for online business activities.
     */
    const WEBMONEY = 'webmoney';

    /**
     * PayByVouchers via oBeP
     * @deprecated Payment method is deprecated and will be removed
     */
    const PAYBYVOUCHER_YEEPAY = 'paybyvoucher_yeepay';

    /**
     * PayByVouchers via Credit/Debit Cards
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const PAYBYVOUCHER_SALE = 'paybyvoucher_sale';

    /**
     * Voucher-based payment
     */
    const PAYSAFECARD = 'paysafecard';

    /**
     * Supports payments via EPS, SafetyPay, TrustPay, ELV, Przelewy24, and GiroPay
     */
    const PPRO = 'ppro';

    /**
     * TrustPay is a real-time bank transfer payment service, which is widely used in the Czech Republic and Slovakia.
     * @deprecated since 1.21.5 - the TrustPay API was deprecated by Genesis
     */
    const TRUSTPAY = 'trustpay';

    /**
     * My Bank is an overlay banking system
     */
    const MY_BANK = 'my_bank';

    /**
     * Bancontact is a local Belgian debit card scheme. All Belgian debit cards are co-branded Bancontact and Maestro.
     */
    const BANCONTACT = 'bcmc';

    /**
     * QIWI Wallet is a very popular Eastern European e-wallet.
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const QIWI = 'qiwi';

    /**
     * iDEAL
     *
     * Direct PPRO transaction
     */
    const IDEAL = 'ideal';

    /**
     * e-payment standard
     *
     * Direct PPRO transaction
     */
    const EPS = 'eps';

    /**
     * GiroPay
     *
     * Direct PPRO transaction
     */
    const GIROPAY = 'giropay';

    /**
     * Bank transfer payment, popular in Germany
     */
    const SOFORT = 'sofort';

    /**
     * Global payment system, that makes instant cross-border payments more secure, regulated by Danish and Swiss FSA
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const INPAY = 'inpay';

    /**
     * P24 is an online banking payment, popular in Poland
     */
    const P24 = 'p24';

    /**
     * Trustly is a fast and secure oBeP-style alternative payment method. It is free of charge and
     * allows you to deposit money directly from your online bank account.
     */
    const TRUSTLY_SALE = 'trustly_sale';

    /**
     * Trustly is an oBeP-style alternative payment method that allows you to
     * withdraw money directly from your online bank account using your bank credentials.
     *
     * @deprecated Since 1.18.9 Payment method is deprecated and will be removed
     */
    const TRUSTLY_WITHDRAWAL = 'trustly_withdrawal';

    /**
     * PayPal Express Checkout is a fast, easy way for buyers to pay with PayPal.
     * Express Checkout eliminates one of the major causes of checkout abandonment by giving buyers
     * all the transaction details at once, including order details, shipping options, insurance choices, and tax totals
     *
     * @deprecated 1.19.2 Payment method is deprecated and will be removed
     */
    const PAYPAL_EXPRESS = 'paypal_express';

    /**
     * Sepa Direct Debit Payment, popular in Germany.
     * Single Euro Payments Area (SEPA) allows consumers to make cashless Euro payments to
     * any beneficiary located anywhere in the Euro area using only a single bank account
     */
    const SDD_SALE = 'sdd_sale';

    /**
     * Sepa Direct Debit Payout, popular in Germany.
     * Processed as a SEPA CreditTransfer and can be used for all kind of payout services
     * across the EU with 1 day settlement. Suitable for Gaming, Forex-Binaries, Affiliate Programs or Merchant payouts
     */
    const SCT_PAYOUT = 'sct_payout';

    /**
     * Sepa Direct Debit Refund Transaction.
     * Refunds allow to return already billed amounts to customers.
     */
    const SDD_REFUND = 'sdd_refund';

    /**
     * Sepa Direct Debit initial recurring
     */
    const SDD_INIT_RECURRING_SALE = 'sdd_init_recurring_sale';

    /**
     * Sepa Direct Debit RecurringSale transaction is a "repeated" transaction,
     * which follows and references an SDD initial transaction
     */
    const SDD_RECURRING_SALE = 'sdd_recurring_sale';

    /**
     * iDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real-time payments without a credit card.
     * Using iDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * iDebit Payin is only asynchronous and uses eCheck.
     */
    const IDEBIT_PAYIN = 'idebit_payin';

    /**
     * iDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real-time payments without a credit card.
     * Using iDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * iDebit Payout is only synchronous and uses eCheck.
     */
    const IDEBIT_PAYOUT = 'idebit_payout';

    /**
     * InstaDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real- time payments without a credit card.
     * Using InstaDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * InstaDebit Payin is only asynchronous and uses online bank transfer.
     */
    const INSTA_DEBIT_PAYIN = 'insta_debit_payin';

    /**
     * InstaDebit connects consumers to their online banking directly from checkout, enabling secure,
     * real- time payments without a credit card.
     * Using InstaDebit allows consumers to transfer funds to merchants without
     * revealing their personal banking information.
     * InstaDebit Payout is only synchronous and uses online bank transfer.
     */
    const INSTA_DEBIT_PAYOUT = 'insta_debit_payout';

    /**
     * Citadel is an oBeP-style alternative payment method.
     * It offers merchants the ability to send/receive consumer payments via the use of bank transfer functionality
     * available from the consumer’s online banking website.
     *
     * Payins are only asynchronous. After initiating a transaction the transaction status is set to pending async and
     * the consumer is redirected to Citadel’s Instant Banking website.
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const CITADEL_PAYIN = 'citadel_payin';

    /**
     * Citadel is an oBeP-style alternative payment method.
     * It offers merchants the ability to send/receive consumer payments via the use of bank transfer functionality
     * available from the consumer’s online banking website.
     *
     * The workflow for Payouts is synchronous, there is no redirect to the Citadel’s Instant Banking website.
     * There are different required fields per country, e.g. IBAN and SWIFT Code or Account Number and Branch Code
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const CITADEL_PAYOUT = 'citadel_payout';

    /**
     * Earthport’s service supports payouts from e-commerce companies. The workflow is synchronous, there
     * is no redirect to the Earthport’s website. There are different required fields per country, e.g. IBAN
     * or Account Number.
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const EARTHPORT = 'earthport';

    /**
     * Alipay is an oBeP-style alternative payment method that allows you to pay directly with your ebank account.
     * After initiating a transaction Alipay will redirect you to their page. There you will see a picture of a QR code,
     * which you will have to scan with your Alipay mobile application.
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const ALIPAY = 'alipay';

    /**
     * WeChat Pay solution offers merchants access to the over 300 million WeChat users that have linked payment
     * to their WeChat account. The solution works on desktop and mobile via a QR code generation platform.
     */
    const WECHAT = 'wechat';

    /**
     * Online Banking is an oBeP-style alternative payment method that allows you to pay directly
     * with your ebank account. After initiating a transaction, the online banking will redirect you to their page.
     * There you will find a list with available banks to finish the payment.
     */
    const ONLINE_BANKING_PAYIN = 'online_banking';

    /**
     * Bank Pay-out is a bank pay-out method. It allows merchants to transfer funds directly to customers’
     * bank accounts.
     */
    const ONLINE_BANKING_PAYOUT = 'bank_payout';

    /**
     * TCS Thecontainerstore transactions are made using gift cards provided by TCS The amount from a
     * Container Store Transactions is immediately billed to the customer’s gift card.
     * It can be reversed via a void transaction.
     */
    const TCS = 'container_store';

    /**
     * Fashioncheque transactions are made using gift card provided by Fashioncheque.
     *
     * Using a fashioncheque transaction, the amount is immediately billed to the customer’s gift card.
     * It can be reversed via a void transaction on the same day of the transaction.
     * They can also be refunded.
     */
    const FASHIONCHEQUE = 'fashioncheque';

    /**
     * Intersolve transactions are made using gift card provided by Intersolve
     * Using a intersolve transaction, the amount is immediately billed to the customer’s gift card.
     * It can be reversed via a void transaction.
     */
    const INTERSOLVE = 'intersolve';

    /**
     * With Klarna Authorize transactions, you can confirm that an order is successful.
     * After settling the transaction (e.g. shipping the goods), you should use klarna_capture transaction
     * type to capture the amount.
     * Klarna authorize transaction will automatically be cancelled after a certain time frame, most likely two weeks.
     */
    const KLARNA_AUTHORIZE = 'klarna_authorize';

    /**
     * Klarna capture settles a klarna_authorize transaction.
     * Do this when you are shipping goods, for example. A klarna_capture can only be used after an
     * klarna_authorize on the same transaction.
     * Therefore, the reference id of the klarna authorize transaction is mandatory.
     */
    const KLARNA_CAPTURE = 'klarna_capture';

    /**
     * Klarna Refunds allow to return already billed amounts to customers.
     * The amount can be fully or partially refunded. Klarna refunds can only be done on former klarna_capture(settled)
     * transactions.
     * Therefore, the reference id for the corresponding transaction is mandatory
     */
    const KLARNA_REFUND = 'klarna_refund';

    /**
     * Zimpler is a Swedish payment method.
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const ZIMPLER = 'zimpler';

    /**
     * Banco do Brasil offers online bank transfer payment service.
     */
    const BANCO_DO_BRASIL = 'banco_do_brasil';

    /**
     * Entercash is a payment method provider across Europe
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const ENTERCASH = 'entercash';

    /**
     * InstantTransfer is a payment method in Germany
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const INSTANT_TRANSFER = 'instant_transfer';

    /**
     * PayU is a payment method for Czech Republic and Poland
     */
    const PAYU = 'payu';

    /**
     * Multibanco allows Portuguese shoppers to do payments through the Internet by using virtual credit cards
     */
    const MULTIBANCO = 'multibanco';

    /**
     * BitPay is a cryptocurrency payments provider supporting blockchain payments
     * with Bitcoin (BTC) and BitcoinCash (BCH).
     */
    const BITPAY_SALE = 'bitpay_sale';

    /**
     * BitPay Refund is a custom refund method which will handle the asynchronous BitPay refund workflow.
     * BitPay refunds can only be done on former transactions. Therefore, the reference id for the
     * corresponding BitPay Sale transaction is mandatory.
     */
    const BITPAY_REFUND = 'bitpay_refund';

    /**
     * BitPay Payout is a crypto currency payout method where merchants are requesting
     * payouts in FIAT currency and the funds are transfered in Bitcoin equivalent to a crypto wallet address.
     */
    const BITPAY_PAYOUT = 'bitpay_payout';

    /**
     * Banco de Occidente is a cash payment method for Colombia
     */
    const BANCO_DE_OCCIDENTE = 'banco_de_occidente';

    /**
     * Baloto is a cash payment option in Colombia. It allows the customers to receive a voucher at check-out.
     * The voucher can then be paid in any of the Via Boleto offices in cash.
     */
    const BALOTO = 'baloto';

    /**
     * Banamex is local card payment in Mexico
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const BANAMEX = 'banamex';

    /**
     * Boleto is a payment service in Brazil
     */
    const BOLETO = 'boleto';

    /**
     * Astropay Direct is Online Banking ePayment which allows the customers to pay with their bank accounts
     * in their local currency. Customers go straight from the merchant checkout page to a payment interface,
     * which connects the customer with their bank of preference.
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const ASTROPAY_DIRECT = 'astropay_direct';

    /**
     * Emprese De Energia is a cash payment in Colombia
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const EMPRESE_DE_ENERGIA = 'emprese_de_energia';

    /**
     * Carulla is a payment service in Columbia that allows its users to send money,
     * top up their cell phone and payments.
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const CARULLA = 'carulla';

    /**
     * OXXO is the preferred payment method in Mexico. It is a cash payment via a barcode document
     * thats accepted in more than 14,000 stores.
     */
    const OXXO = 'oxxo';

    /**
     * Pago Facil is a payment service in Argentina that allows its users to send money,
     * top up their cell phone and payments.
     */
    const PAGO_FACIL = 'pago_facil';

    /**
     * Redpagos is a cash payment in Uruguay
     */
    const REDPAGOS = 'redpagos';

    /**
     * Santander Cash is local card payment in Mexico
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const SANTANDER_CASH = 'santander_cash';

    /**
     * Surtimax is a cash payment method in Columbia
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const SURTIMAX = 'surtimax';

    /**
     * Efecty is an offline cash payment voucher option in Colombia.
     */
    const EFECTY = 'efecty';

    /**
     * Argencard is a debit or credit card used in Argentina. It allows online shoppers to pay offline
     * for their online purchases at over 150,000 physical outlets.
     */
    const ARGENCARD = 'argencard';

    /**
     * Aura is a local Brazilian credit card.
     */
    const AURA = 'aura';

    /**
     * Cencosud is a local credit card in Argentina
     */
    const CENCOSUD = 'cencosud';

    /**
     * Elo is a local Brazilian payment card.
     */
    const ELO = 'elo';

    /**
     * Hipercard is a local credit card in Brazil
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const HIPERCARD = 'hipercard';

    /**
     * Cabal is a local debit/credit card brand in Argentina which can be used for online purchases.
     */
    const CABAL = 'cabal';

    /**
     * Naranja is a local credit card issued in Argentina which can be used for purchases over the internet.
     */
    const NARANJA = 'naranja';

    /**
     * Nativa is an Argentinian credit card provided by the National Bank of Argentina.
     */
    const NATIVA = 'nativa';

    /**
     * Tarjeta Shopping is a cash payment in Argentina.
     */
    const TARJETA_SHOPPING = 'tarjeta_shopping';

    /**
     * Neosurf is a prepaid card (voucher) that is used for online shopping. The card is available in over 100,000
     * stores worldwide, where customers can buy the prepaid vouchers, denominated up to EUR 250.00 or its equivalent
     * in other currencies.
     */
    const NEOSURF = 'neosurf';

    /**
     * Safetypay is a real-time bank transfer system that operates in more than 10 different countries.
     * Their main market is in Latin America.
     */
    const SAFETYPAY = 'safetypay';

    /**
     * Itau is a real-time online bank transfer method and a virtual card.
     */
    const ITAU = 'itau';

    /**
     * Santander is an online bank transfer for ecommerce purchases. Consumers use their trusted home
     * banking environment, merchants benefit from payment guarantee and swift settlement.
     */
    const SANTANDER = 'santander';

    /**
     * Bancomer offers two options for payments in Mexico, cash payment and bank transfer.
     */
    const BANCOMER = 'bancomer';

    /**
     * Bradesco is a payment service in Brazil
     */
    const BRADESCO = 'bradesco';

    /**
     * Astropay Card is the most popular virtual pre-paid card for making deposits and withdrawals. It is accepted
     * at hundreds of online sites all around the globe. It is the preferred option by users because of its
     * instantaneity, flexibility, confidentiality and safety.
     *
     * @deprecated Payment method is deprecated and will be removed
     */
    const ASTROPAY_CARD = 'astropay_card';

    /**
     * RapiPago from Argentina is an offline payment method used for online purchases.
     * Shoppers buy their goods and services online and pay offline at one of the 6,000+ RapiPago payment locations.
     */
    const RAPI_PAGO = 'rapi_pago';

    /**
     * PSE (Pagos Seguros en Linea) is the preferred alternative payment solution in Colombia.
     * The solution consists of an interface that offers the client the option to pay for their online purchases
     * in cash, directing it to their online banking.
     */
    const PSE = 'pse';

    /**
     * Incremental authorizations are used in preauthorization workflow to extend the preauthorization amount,
     * extend the preauthorization time-frame
     */
    const INCREMENTAL_AUTHORIZE = 'incremental_authorize';

    /**
     * Partial reversal transactions are used in preauthorization workflow to release a part of the
     * total authorized amount before a partial capture to be submitted. A transaction of this type
     * should refer the preauthorization directly.
     */
    const PARTIAL_REVERSAL = 'partial_reversal';

    /**
     * eZeeCard Payout is a sync based payout method.
     * It's merchant initiated and can only reference specific transaction types
     */
    const EZEECARD_PAYOUT = 'ezeecard_payout';

    /**
     * TransferTo Payout is an APM which provides 3 different payment services:
     * BankAccount, MobileWallet and CashPickup. Merchant sends money to a consumer.
     */
    const TRANSFER_TO_PAYOUT = 'transfer_to_payout';

    /**
     * Davivienda is offering the Bill pay service which is a fast, easy and secure way to pay and manage
     * your bills online to anyone, anytime in Colombia.
     */
    const DAVIVIENDA = 'davivienda';

    /**
     * Webpay is a Chilean real-time bank transfer method.
     */
    const WEBPAY = 'webpay';

    /**
     * Apple pay is payment method working with apple devices
     */
    const APPLE_PAY = 'apple_pay';

    /**
     * UPI (Unified Payment Interface) transaction is an alternative payment method
     * which allows users to transfer money between bank accounts.
     */
    const UPI = 'upi';

    /**
     * PostFinance is an online banking provider in Switzerland
     */
    const POST_FINANCE = 'post_finance';

    /**
     * Google Pay allows shoppers to purchase with credit and debit cards linked to their Google account.
     */
    const GOOGLE_PAY = 'google_pay';

    /**
     * PayPal transaction is a fast and easy way for buyers to pay with their PayPal account.
     * It gives buyers all the transaction details at once, including order details, shipping options,
     * insurance choices, and tax totals.
     */
    const PAY_PAL = 'pay_pal';

    /**
     * African Mobile Sale, otherwise known as Charge, is an APM used to process Mobile network operator payments.
     * It is an async payment method and will be approved once the payment is processed with the Mobile network
     * operator
     */
    const AFRICAN_MOBILE_SALE = 'african_mobile_sale';

    /**
     * African Mobile Payout, or otherwise known as Disbursement, is an APM used to process Mobile network operator
     * payments. It is an async payment method and will be approved once the payment is processed with the Mobile
     * network operator
     */
    const AFRICAN_MOBILE_PAYOUT = 'african_mobile_payout';

    /**
     * Russian Mobile Sale, otherwise known as Charge, is an APM used to process Mobile network operator payments.
     * It is an async payment method and will be approved once the payment is processed by the Mobile network operator.
     * Notice: Russian Mobile Sale does not support refund and void.
     */
    const RUSSIAN_MOBILE_SALE = 'russian_mobile_sale';

    /**
     * Russian Mobile Payout, or otherwise known as Disbursement, is an APM used to process Mobile network operator
     * payments. It is an async payment method and will be approved once the payment is processed by the
     * Mobile network operator. Notice: Russian Mobile Payout does not support refund and void.
     */
    const RUSSIAN_MOBILE_PAYOUT = 'russian_mobile_payout';

    /**
     * Pix is a payment service created by the Central Bank of Brazil (BACEN),
     * which represents a new way of receiving/sending money. Pix allows payments
     * to be made instantly. The customer can pay bills, invoices, public utilities,
     * transfer and receive credits in a facilitated manner, using only Pix keys (CPF/CNPJ).
     */
    const PIX = 'pix';

    /**
     * Retrieve all available transaction Types
     *
     * @return array
     */
    public static function getAll()
    {
        return Common::getClassConstants(__CLASS__);
    }

    /**
     * @param $type
     *
     * @return bool|string
     */
    public static function getFinancialRequestClassForTrxType($type)
    {
        $map = [
            self::VOID                    => 'Cancel',
            self::CAPTURE                 => 'Capture',
            self::REFUND                  => 'Refund',
            self::ABNIDEAL                => 'Alternatives\ABNiDEAL',
            self::EARTHPORT               => 'Alternatives\Earthport',
            self::INPAY                   => 'Alternatives\INPay',
            self::KLARNA_AUTHORIZE        => 'Alternatives\Klarna\Authorize',
            self::KLARNA_CAPTURE          => 'Alternatives\Klarna\Capture',
            self::KLARNA_REFUND           => 'Alternatives\Klarna\Refund',
            self::P24                     => 'Alternatives\P24',
            self::PAYPAL_EXPRESS          => 'Alternatives\PaypalExpress',
            self::POLI                    => 'Alternatives\POLi',
            self::PPRO                    => 'Alternatives\PPRO',
            self::SOFORT                  => 'Alternatives\Sofort',
            self::TRANSFER_TO_PAYOUT      => 'Alternatives\TransferTo\Payout',
            self::TRUSTLY_SALE            => 'Alternatives\Trustly\Sale',
            self::TRUSTLY_WITHDRAWAL      => 'Alternatives\Trustly\Withdrawal',
            self::INIT_RECURRING_SALE     => 'Cards\Recurring\InitRecurringSale',
            self::INIT_RECURRING_SALE_3D  => 'Cards\Recurring\InitRecurringSale3D',
            self::RECURRING_SALE          => 'Cards\Recurring\RecurringSale',
            self::ARGENCARD               => 'Cards\Argencard',
            self::AURA                    => 'Cards\Aura',
            self::AUTHORIZE               => 'Cards\Authorize',
            self::AUTHORIZE_3D            => 'Cards\Authorize3D',
            self::BANCONTACT              => 'Cards\Bancontact',
            self::CABAL                   => 'Cards\Cabal',
            self::CENCOSUD                => 'Cards\Cencosud',
            self::CREDIT                  => 'Cards\Credit',
            self::ELO                     => 'Cards\Elo',
            self::EZEECARD_PAYOUT         => 'Cards\EzeeCardPayout',
            self::HIPERCARD               => 'Cards\Hipercard',
            self::NARANJA                 => 'Cards\Naranja',
            self::NATIVA                  => 'Cards\Nativa',
            self::PAYOUT                  => 'Cards\Payout',
            self::SALE                    => 'Cards\Sale',
            self::SALE_3D                 => 'Cards\Sale3D',
            self::TARJETA_SHOPPING        => 'Cards\TarjetaShopping',
            self::BALOTO                  => 'CashPayments\Baloto',
            self::BANAMEX                 => 'CashPayments\Banamex',
            self::BANCO_DE_OCCIDENTE      => 'CashPayments\BancoDeOccidente',
            self::BOLETO                  => 'CashPayments\Boleto',
            self::CARULLA                 => 'CashPayments\Carulla',
            self::EFECTY                  => 'CashPayments\Efecty',
            self::EMPRESE_DE_ENERGIA      => 'CashPayments\EmpreseDeEnergia',
            self::OXXO                    => 'CashPayments\Oxxo',
            self::PAGO_FACIL              => 'CashPayments\PagoFacil',
            self::PIX                     => 'CashPayments\Pix',
            self::REDPAGOS                => 'CashPayments\Redpagos',
            self::SANTANDER_CASH          => 'CashPayments\SantanderCash',
            self::SURTIMAX                => 'CashPayments\Surtimax',
            self::BITPAY_PAYOUT           => 'Crypto\BitPay\Payout',
            self::BITPAY_REFUND           => 'Crypto\BitPay\Refund',
            self::BITPAY_SALE             => 'Crypto\BitPay\Sale',
            self::TCS                     => 'GiftCards\Tcs',
            self::FASHIONCHEQUE           => 'GiftCards\Fashioncheque',
            self::INTERSOLVE              => 'GiftCards\Intersolve',
            self::APPLE_PAY               => 'Mobile\ApplePay',
            self::GOOGLE_PAY              => 'Mobile\GooglePay',
            self::RUSSIAN_MOBILE_SALE     => 'Mobile\RussianMobileSale',
            self::AFRICAN_MOBILE_SALE     => 'Mobile\AfricanMobileSale.php',
            self::ALIPAY                  => 'OnlineBankingPayments\Alipay',
            self::ASTROPAY_DIRECT         => 'OnlineBankingPayments\AstropayDirect',
            self::BANCO_DO_BRASIL         => 'OnlineBankingPayments\BancoDoBrasil',
            self::BANCOMER                => 'OnlineBankingPayments\Bancomer',
            self::BRADESCO                => 'OnlineBankingPayments\Bradesco',
            self::CITADEL_PAYIN           => 'OnlineBankingPayments\Citadel\Payin',
            self::CITADEL_PAYOUT          => 'OnlineBankingPayments\Citadel\Payout',
            self::DAVIVIENDA              => 'OnlineBankingPayments\Davivienda',
            self::ENTERCASH               => 'OnlineBankingPayments\Entercash',
            self::EPS                     => 'OnlineBankingPayments\Eps',
            self::GIROPAY                 => 'OnlineBankingPayments\Giropay',
            self::IDEAL                   => 'OnlineBankingPayments\Ideal',
            self::IDEBIT_PAYIN            => 'OnlineBankingPayments\iDebit\Payin',
            self::IDEBIT_PAYOUT           => 'OnlineBankingPayments\iDebit\Payout',
            self::INSTA_DEBIT_PAYIN       => 'OnlineBankingPayments\InstaDebit\PayIn',
            self::INSTA_DEBIT_PAYOUT      => 'OnlineBankingPayments\InstaDebit\Payout',
            self::INSTANT_TRANSFER        => 'OnlineBankingPayments\InstantTransfer',
            self::ITAU                    => 'OnlineBankingPayments\Itau',
            self::MULTIBANCO              => 'OnlineBankingPayments\Multibanco',
            self::MY_BANK                 => 'OnlineBankingPayments\MyBank',
            self::ONLINE_BANKING_PAYIN    => 'OnlineBankingPayments\OnlineBanking\Payin',
            self::ONLINE_BANKING_PAYOUT   => 'OnlineBankingPayments\OnlineBanking\Payout',
            self::PAYU                    => 'OnlineBankingPayments\PayU',
            self::POST_FINANCE            => 'OnlineBankingPayments\PostFinance',
            self::PSE                     => 'OnlineBankingPayments\Pse',
            self::RAPI_PAGO               => 'OnlineBankingPayments\RapiPago',
            self::SAFETYPAY               => 'OnlineBankingPayments\SafetyPay',
            self::SANTANDER               => 'OnlineBankingPayments\Santander',
            self::TRUSTPAY                => 'OnlineBankingPayments\TrustPay',
            self::UPI                     => 'OnlineBankingPayments\Upi',
            self::WEBPAY                  => 'OnlineBankingPayments\Webpay',
            self::WECHAT                  => 'OnlineBankingPayments\WeChat',
            self::PAYBYVOUCHER_YEEPAY     => 'PayByVouchers\oBeP',
            self::PAYBYVOUCHER_SALE       => 'PayByVouchers\Sale',
            self::AFRICAN_MOBILE_PAYOUT   => 'Payout\AfricanMobilePayout',
            self::RUSSIAN_MOBILE_PAYOUT   => 'Payout\RussianMobilePayout',
            self::INCREMENTAL_AUTHORIZE   => 'Preauthorization\IncrementalAuthorize',
            self::PARTIAL_REVERSAL        => 'Preauthorization\PartialReversal',
            self::SCT_PAYOUT              => 'SCT\Payout',
            self::SDD_INIT_RECURRING_SALE => 'SDD\Recurring\InitRecurringSale',
            self::SDD_RECURRING_SALE      => 'SDD\Recurring\RecurringSale',
            self::SDD_REFUND              => 'SDD\Refund',
            self::SDD_SALE                => 'SDD\Sale',
            self::ASTROPAY_CARD           => 'Vouchers\AstropayCard',
            self::CASHU                   => 'Vouchers\CashU',
            self::NEOSURF                 => 'Vouchers\Neosurf',
            self::PAYSAFECARD             => 'Vouchers\Paysafecard',
            self::EZEEWALLET              => 'Wallets\eZeeWallet',
            self::NETELLER                => 'Wallets\Neteller',
            self::QIWI                    => 'Wallets\Qiwi',
            self::PAY_PAL                 => 'Wallets\PayPal',
            self::WEBMONEY                => 'Wallets\WebMoney',
            self::ZIMPLER                 => 'Wallets\Zimpler',
        ];

        return isset($map[$type]) ? 'Financial\\' . $map[$type] : false;
    }

    /**
     * Check whether this is a valid (known) transaction type
     *
     * @param string $type
     *
     * @return bool
     */
    public static function isValidTransactionType($type)
    {
        $transactionTypes = \Genesis\Utils\Common::getClassConstants(__CLASS__);

        return in_array(strtolower($type), $transactionTypes);
    }

    /**
     * Get valid WPF transaction types
     *
     * @return array
     */
    public static function getWPFTransactionTypes()
    {
        return [
            self::ARGENCARD,
            self::APPLE_PAY,
            self::AURA,
            self::AUTHORIZE,
            self::AUTHORIZE_3D,
            self::BALOTO,
            self::BANCOMER,
            self::BANCONTACT,
            self::BANCO_DE_OCCIDENTE,
            self::BANCO_DO_BRASIL,
            self::BITPAY_PAYOUT,
            self::BITPAY_SALE,
            self::BOLETO,
            self::BRADESCO,
            self::CABAL,
            self::CASHU,
            self::CENCOSUD,
            self::DAVIVIENDA,
            self::EFECTY,
            self::ELO,
            self::EPS,
            self::EZEEWALLET,
            self::FASHIONCHEQUE,
            self::GIROPAY,
            self::GOOGLE_PAY,
            self::IDEAL,
            self::IDEBIT_PAYIN,
            self::INIT_RECURRING_SALE,
            self::INIT_RECURRING_SALE_3D,
            self::INSTA_DEBIT_PAYIN,
            self::INTERSOLVE,
            self::ITAU,
            self::KLARNA_AUTHORIZE,
            self::MULTIBANCO,
            self::MY_BANK,
            self::NARANJA,
            self::NATIVA,
            self::NEOSURF,
            self::NETELLER,
            self::ONLINE_BANKING_PAYIN,
            self::OXXO,
            self::P24,
            self::PAGO_FACIL,
            self::PAY_PAL,
            self::PAYSAFECARD,
            self::PAYU,
            self::PIX,
            self::POLI,
            self::POST_FINANCE,
            self::PPRO,
            self::PSE,
            self::RAPI_PAGO,
            self::REDPAGOS,
            self::RUSSIAN_MOBILE_SALE,
            self::SAFETYPAY,
            self::SALE,
            self::SALE_3D,
            self::SANTANDER,
            self::SDD_INIT_RECURRING_SALE,
            self::SDD_SALE,
            self::SOFORT,
            self::TARJETA_SHOPPING,
            self::TCS,
            self::TRUSTLY_SALE,
            self::UPI,
            self::WEBMONEY,
            self::WEBPAY,
            self::WECHAT
        ];
    }

    /**
     * Check whether this is a valid (known) transaction type
     *
     * @param string $type
     *
     * @return bool
     */
    public static function isValidWPFTransactionType($type)
    {
        return in_array(strtolower($type), self::getWPFTransactionTypes());
    }

    /**
     * Get valid split payment transaction types
     *
     * @return array
     */
    public static function getSplitPaymentsTrxTypes()
    {
        return [
            self::SALE,
            self::SALE_3D,
            self::TCS,
            self::FASHIONCHEQUE,
            self::INTERSOLVE
        ];
    }

    /**
     * Check whether this is a valid (known) split payment transaction type
     *
     * @param string $type
     *
     * @return bool
     */
    public static function isValidSplitPaymentTrxType($type)
    {
        return in_array(strtolower($type), self::getSplitPaymentsTrxTypes());
    }

    /**
     * Check whether this is a valid (known) transaction type
     *
     * @param string $type
     *
     * @return bool
     */
    public static function isPayByVoucher($type)
    {
        $transactionTypesList = [
            self::PAYBYVOUCHER_YEEPAY,
            self::PAYBYVOUCHER_SALE
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function canCapture($type)
    {
        $transactionTypesList = [
            self::AUTHORIZE,
            self::AUTHORIZE_3D,
            self::KLARNA_AUTHORIZE,
            self::APPLE_PAY,
            self::GOOGLE_PAY,
            self::PAY_PAL
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function canRefund($type)
    {
        $transactionTypesList = [
            self::APPLE_PAY,
            self::AFRICAN_MOBILE_PAYOUT,
            self::AFRICAN_MOBILE_SALE,
            self::BALOTO,
            self::BANCOMER,
            self::BANCONTACT,
            self::BANCO_DE_OCCIDENTE,
            self::BANCO_DO_BRASIL,
            self::BITPAY_SALE,
            self::BOLETO,
            self::BRADESCO,
            self::CAPTURE,
            self::CASHU,
            self::DAVIVIENDA,
            self::EFECTY,
            self::EPS,
            self::FASHIONCHEQUE,
            self::GIROPAY,
            self::IDEAL,
            self::IDEBIT_PAYIN,
            self::INIT_RECURRING_SALE,
            self::INIT_RECURRING_SALE_3D,
            self::ITAU,
            self::KLARNA_CAPTURE,
            self::MY_BANK,
            self::MY_BANK,
            self::NEOSURF,
            self::OXXO,
            self::ONLINE_BANKING_PAYIN,
            self::P24,
            self::PAGO_FACIL,
            self::PARTIAL_REVERSAL,
            self::PAY_PAL,
            self::PAYU,
            self::PIX,
            self::PPRO,
            self::PSE,
            self::POST_FINANCE,
            self::RAPI_PAGO,
            self::RECURRING_SALE,
            self::REDPAGOS,
            self::SAFETYPAY,
            self::SALE,
            self::SALE_3D,
            self::SANTANDER,
            self::SDD_INIT_RECURRING_SALE,
            self::SDD_RECURRING_SALE,
            self::SDD_SALE,
            self::SOFORT,
            self::TRUSTLY_SALE,
            self::UPI,
            self::WEBPAY,
            self::WECHAT,
            self::ZIMPLER,
            self::GOOGLE_PAY,
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function canVoid($type)
    {
        $transactionTypesList = [
            self::AFRICAN_MOBILE_PAYOUT,
            self::AFRICAN_MOBILE_SALE,
            self::AUTHORIZE,
            self::AUTHORIZE_3D,
            self::TRUSTLY_SALE,
            self::TCS,
            self::FASHIONCHEQUE,
            self::INTERSOLVE,
            self::REFUND,
            self::CAPTURE,
            self::APPLE_PAY,
            self::SALE,
            self::SALE_3D,
            self::GOOGLE_PAY,
            self::PAY_PAL
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param string $type
     *
     * @return bool
     */
    public static function is3D($type)
    {
        return Common::endsWith($type, '3d');
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public static function isAuthorize($type)
    {
        $transactionTypesList = [
            self::AUTHORIZE,
            self::AUTHORIZE_3D,
            self::KLARNA_AUTHORIZE
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public static function isCapture($type)
    {
        $transactionTypesList = [
            self::CAPTURE,
            self::KLARNA_CAPTURE
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * @param $type
     *
     * @return bool
     */
    public static function isRefund($type)
    {
        $transactionTypesList = [
            self::REFUND,
            self::SDD_REFUND,
            self::KLARNA_REFUND,
            self::BITPAY_REFUND
        ];

        return in_array(strtolower($type), $transactionTypesList);
    }

    /**
     * Get capture transaction class from authorize type
     *
     * @param $authorizeType
     * @return string
     */
    public static function getCaptureTransactionClass($authorizeType)
    {
        switch ($authorizeType) {
            case self::KLARNA_AUTHORIZE:
                return 'Financial\Alternatives\Klarna\Capture';
            default:
                return 'Financial\Capture';
            break;
        }
    }

    /**
     * Get refund transaction class from authorize type
     *
     * @param $captureType
     * @return string
     */
    public static function getRefundTransactionClass($captureType)
    {
        switch ($captureType) {
            case self::KLARNA_CAPTURE:
                return 'Financial\Alternatives\Klarna\Refund';
            case self::BITPAY_SALE:
                return 'Financial\Crypto\BitPay\Refund';
            case self::SDD_SALE:
            case self::SDD_RECURRING_SALE:
            case self::SDD_INIT_RECURRING_SALE:
                return 'Financial\SDD\Refund';
                break;
            default:
                return 'Financial\Refund';
                break;
        }
    }

    /**
     * Get custom required parameters with values per transaction
     * @param string $type
     * @return array|bool
     */
    public static function getCustomRequiredParameters($type)
    {
        $method = 'for' . Common::snakeCaseToCamelCase($type);

        if (!method_exists(CustomRequiredParameters::class, $method)) {
            return false;
        }

        return CustomRequiredParameters::$method();
    }

    /**
     * Get Deprecated Processing Requests
     *
     * @return array
     */
    public static function getFinancialDeprecatedRequests()
    {
        $data = array();

        $transactions = [
            self::ABNIDEAL,
            self::ALIPAY,
            self::ASTROPAY_CARD,
            self::ASTROPAY_DIRECT,
            self::BANAMEX,
            self::CARULLA,
            self::CITADEL_PAYIN,
            self::CITADEL_PAYOUT,
            self::EARTHPORT,
            self::EMPRESE_DE_ENERGIA,
            self::ENTERCASH,
            self::HIPERCARD,
            self::INSTANT_TRANSFER,
            self::INPAY,
            self::PAYBYVOUCHER_SALE,
            self::PAYBYVOUCHER_YEEPAY,
            self::PAYPAL_EXPRESS,
            self::QIWI,
            self::SANTANDER_CASH,
            self::SURTIMAX,
            self::TRUSTLY_WITHDRAWAL,
            self::TRUSTPAY,
            self::ZIMPLER
        ];

        foreach ($transactions as $transaction) {
            $data[$transaction] = self::getFinancialRequestClassForTrxType($transaction);
        }

        return $data;
    }

    /**
     * Get deprecated Request
     *
     * @return array
     */
    public static function getDeprecatedRequests()
    {
        return array_merge(
            self::getFinancialDeprecatedRequests(),
            Services::getServiceDeprecatedRequests()
        );
    }

    /**
     * Get Card payment types
     *
     * @return array
     */
    public static function getCardTransactionTypes()
    {
        return [
            Types::AUTHORIZE,
            Types::AUTHORIZE_3D,
            Types::SALE,
            Types::SALE_3D,
            Types::INIT_RECURRING_SALE,
            Types::INIT_RECURRING_SALE_3D
        ];
    }
}
