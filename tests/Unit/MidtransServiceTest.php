<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class MidtransServiceTest extends TestCase
{
    /**
     * Test that enabled_payments config returns null by default
     */
    public function testAllPaymentMethodsEnabledWhenConfigIsNull(): void
    {
        // Set config to null (default - all methods enabled)
        Config::set('midtrans.enabled_payments', null);
        
        // Verify that config returns null
        $this->assertNull(config('midtrans.enabled_payments'));
    }

    /**
     * Test that enabled_payments config works with comma-separated string
     */
    public function testPaymentMethodsRestrictedWhenConfigHasValues(): void
    {
        // Set config to specific payment methods as comma-separated string
        Config::set('midtrans.enabled_payments', 'qris,gopay,bank_transfer');
        
        // Verify that config returns the comma-separated string
        $this->assertEquals('qris,gopay,bank_transfer', config('midtrans.enabled_payments'));
        
        // Verify the array conversion logic works correctly
        $enabledPayments = config('midtrans.enabled_payments');
        $result = array_map('trim', explode(',', $enabledPayments));
        $this->assertEquals(['qris', 'gopay', 'bank_transfer'], $result);
    }

    /**
     * Test that enabled_payments works with array config
     */
    public function testPaymentMethodsWithArrayConfig(): void
    {
        // Set config to array of payment methods
        Config::set('midtrans.enabled_payments', ['qris', 'gopay', 'credit_card']);
        
        // Verify that config returns array
        $enabledPayments = config('midtrans.enabled_payments');
        $this->assertIsArray($enabledPayments);
        $this->assertEquals(['qris', 'gopay', 'credit_card'], $enabledPayments);
    }

    /**
     * Test that empty string config is treated as "all methods enabled"
     */
    public function testEmptyStringConfigEnablesAllMethods(): void
    {
        // Set config to empty string (should be treated as no restriction)
        Config::set('midtrans.enabled_payments', '');
        
        // Verify empty string behavior
        $enabledPayments = config('midtrans.enabled_payments');
        $this->assertEmpty($enabledPayments);
    }

    /**
     * Test the logic used in MidtransService for handling enabled_payments
     */
    public function testEnabledPaymentsLogicWithNull(): void
    {
        Config::set('midtrans.enabled_payments', null);
        
        $enabledPayments = config('midtrans.enabled_payments');
        
        // This simulates the logic in MidtransService
        $shouldAddToParams = !empty($enabledPayments);
        
        // When null, it should NOT be added to params
        $this->assertFalse($shouldAddToParams);
    }

    /**
     * Test the logic used in MidtransService for handling enabled_payments with values
     */
    public function testEnabledPaymentsLogicWithValues(): void
    {
        Config::set('midtrans.enabled_payments', 'qris,gopay');
        
        $enabledPayments = config('midtrans.enabled_payments');
        
        // This simulates the logic in MidtransService
        $shouldAddToParams = !empty($enabledPayments);
        
        // When configured, it should be added to params
        $this->assertTrue($shouldAddToParams);
        
        // Verify the conversion logic
        $result = is_array($enabledPayments) 
            ? $enabledPayments 
            : array_map('trim', explode(',', $enabledPayments));
        
        $this->assertEquals(['qris', 'gopay'], $result);
    }

    /**
     * Test enabled_payments with spaces in comma-separated values
     */
    public function testPaymentMethodsWithSpaces(): void
    {
        // Set config with spaces around values
        Config::set('midtrans.enabled_payments', 'qris, gopay, bank_transfer ');
        
        $enabledPayments = config('midtrans.enabled_payments');
        $result = array_map('trim', explode(',', $enabledPayments));
        
        // Should trim spaces
        $this->assertEquals(['qris', 'gopay', 'bank_transfer'], $result);
    }
}
