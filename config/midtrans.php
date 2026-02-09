<?php

return [
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => true,
    'is_3ds' => true,
    
    /*
    |--------------------------------------------------------------------------
    | Enabled Payment Methods
    |--------------------------------------------------------------------------
    |
    | Configure which payment methods are available in Midtrans Snap.
    | Leave as null to enable ALL payment methods activated in your Midtrans Dashboard.
    | To restrict payment methods, set MIDTRANS_ENABLED_PAYMENTS in .env file.
    |
    | Available payment methods:
    | - qris: QR Code payment
    | - gopay: GoPay e-wallet
    | - shopeepay: ShopeePay e-wallet
    | - bank_transfer: All bank Virtual Accounts (BCA, BNI, BRI, Mandiri, Permata)
    | - bca_va: BCA Virtual Account
    | - bni_va: BNI Virtual Account
    | - bri_va: BRI Virtual Account
    | - permata_va: Permata Virtual Account
    | - echannel: Mandiri Bill Payment
    | - credit_card: Credit/Debit Card
    | - cimb_clicks: CIMB Clicks
    | - bca_klikbca: BCA KlikBCA
    | - bca_klikpay: BCA KlikPay
    | - bri_epay: BRI e-Pay
    | - danamon_online: Danamon Online Banking
    | - akulaku: Akulaku PayLater
    |
    | Example in .env:
    | MIDTRANS_ENABLED_PAYMENTS=qris,gopay,bank_transfer,credit_card
    |
    */
    'enabled_payments' => env('MIDTRANS_ENABLED_PAYMENTS', null),
];
