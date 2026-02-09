# Midtrans Payment Methods Configuration

## Overview

This document explains how to configure payment methods for Midtrans integration in the LSP certification application.

## Changes Made

### 1. Default Behavior
- **By default**, the application now enables **ALL payment methods** that are activated in your Midtrans Dashboard
- This provides maximum flexibility for users to choose their preferred payment method

### 2. Configuration Support
- Added `MIDTRANS_ENABLED_PAYMENTS` environment variable for optional restriction of payment methods
- Supports both array and comma-separated string formats
- Configuration is completely optional

## Configuration

### Option 1: Enable All Payment Methods (Recommended)

Leave the `MIDTRANS_ENABLED_PAYMENTS` variable empty in your `.env` file:

```env
MIDTRANS_ENABLED_PAYMENTS=
```

This will show **all payment methods** that are activated in your Midtrans Dashboard, including:
- QRIS
- GoPay
- ShopeePay
- Bank Transfer (All VAs: BCA, BNI, BRI, Mandiri, Permata)
- Credit/Debit Cards
- And any other methods you've activated in Midtrans

### Option 2: Restrict to Specific Payment Methods

To limit payment options, specify comma-separated payment method codes in your `.env` file:

```env
MIDTRANS_ENABLED_PAYMENTS=qris,gopay,bank_transfer,credit_card
```

## Available Payment Method Codes

| Code | Description |
|------|-------------|
| `qris` | QR Code payment (QRIS) |
| `gopay` | GoPay e-wallet |
| `shopeepay` | ShopeePay e-wallet |
| `bank_transfer` | All bank Virtual Accounts (BCA, BNI, BRI, Mandiri, Permata) |
| `bca_va` | BCA Virtual Account only |
| `bni_va` | BNI Virtual Account only |
| `bri_va` | BRI Virtual Account only |
| `permata_va` | Permata Virtual Account only |
| `echannel` | Mandiri Bill Payment |
| `credit_card` | Credit/Debit Card |
| `cimb_clicks` | CIMB Clicks |
| `bca_klikbca` | BCA KlikBCA |
| `bca_klikpay` | BCA KlikPay |
| `bri_epay` | BRI e-Pay |
| `danamon_online` | Danamon Online Banking |
| `akulaku` | Akulaku PayLater |

## Examples

### Example 1: E-wallets and QRIS Only
```env
MIDTRANS_ENABLED_PAYMENTS=qris,gopay,shopeepay
```

### Example 2: Bank Transfers and Credit Cards
```env
MIDTRANS_ENABLED_PAYMENTS=bank_transfer,credit_card
```

### Example 3: Specific Bank VAs
```env
MIDTRANS_ENABLED_PAYMENTS=bca_va,bni_va,bri_va
```

## Implementation Details

### Files Modified

1. **`app/Services/MidtransService.php`**
   - Removed hardcoded payment method restriction
   - Added dynamic configuration support
   - Handles both array and string configurations

2. **`config/midtrans.php`**
   - Added `enabled_payments` configuration
   - Comprehensive documentation of available methods

3. **`.env.example`**
   - Added `MIDTRANS_ENABLED_PAYMENTS` with documentation
   - Included examples of usage

### Tests

Created comprehensive unit tests in `tests/Unit/MidtransServiceTest.php`:
- Tests default behavior (null = all methods)
- Tests comma-separated string configuration
- Tests array configuration
- Tests empty string behavior
- Tests actual logic used in MidtransService
- Tests handling of spaces in configuration

All tests pass successfully.

## User Benefits

1. **Better User Experience**
   - Users can now see and choose from multiple payment methods
   - No longer limited to just 3 options (QRIS, GoPay, Bank Transfer)
   - Users can switch between payment methods easily

2. **Flexibility**
   - System administrators can control which methods to show
   - Can adapt to different regions or business requirements
   - Easy to update without code changes

3. **Backward Compatibility**
   - Existing installations continue to work
   - Default behavior enables all methods (improvement over old hardcoded limit)

## Migration Guide

### For Existing Installations

1. No code changes required - the update is automatic
2. After deploying, users will see all activated payment methods by default
3. If you want to restrict methods, add `MIDTRANS_ENABLED_PAYMENTS` to your `.env` file

### For New Installations

1. Follow the standard installation process
2. Configure Midtrans credentials in `.env`
3. Optionally set `MIDTRANS_ENABLED_PAYMENTS` if you want to restrict payment methods

## Troubleshooting

### Payment methods not showing?

1. Check that the payment methods are activated in your Midtrans Dashboard
2. Verify that `MIDTRANS_ENABLED_PAYMENTS` is empty or contains valid codes
3. Clear config cache: `php artisan config:clear`

### Want to test in Sandbox?

1. Make sure `MIDTRANS_IS_PRODUCTION=false` in `.env`
2. Use Sandbox credentials (with `SB-` prefix)
3. Test with Midtrans test payment methods

## References

- [Midtrans Snap Documentation](https://docs.midtrans.com/en/snap/overview)
- [Midtrans Enabled Payments](https://docs.midtrans.com/en/snap/advanced-feature#enabled_payments)
- [Midtrans Dashboard](https://dashboard.midtrans.com/)

## Security Considerations

- Payment processing is handled securely by Midtrans
- No sensitive payment data is stored in the application
- All transactions are logged for audit purposes
- Configuration changes require server access (via `.env` file)

## Support

For issues or questions:
1. Check Midtrans Dashboard for payment method activation status
2. Review server logs for any errors
3. Verify configuration in `.env` file
4. Test in Sandbox mode before going live
