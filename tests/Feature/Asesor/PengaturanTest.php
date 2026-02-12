<?php

namespace Tests\Feature\Asesor;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PengaturanTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that asesor can view pengaturan page
     */
    public function test_asesor_can_view_pengaturan_page(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create([
            'nama' => 'Asesor Test',
            'email' => 'asesor@test.com',
            'role' => 'asesor'
        ]);

        // Act as asesor and visit pengaturan page
        $response = $this->actingAs($asesor)
            ->get(route('asesor.pengaturan'));

        // Assert the page loads successfully
        $response->assertStatus(200);
        $response->assertSee('Pengaturan Akun');
        $response->assertSee('Ubah Password');
        $response->assertSee('Preferensi Akun');
        $response->assertSee($asesor->nama);
        $response->assertSee($asesor->email);
    }

    /**
     * Test that non-asesor cannot access pengaturan page
     */
    public function test_non_asesor_cannot_access_pengaturan_page(): void
    {
        // Create a regular user
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        // Attempt to access pengaturan page
        $response = $this->actingAs($user)
            ->get(route('asesor.pengaturan'));

        // Assert access is denied
        $response->assertStatus(403);
    }

    /**
     * Test that asesor can update password successfully
     */
    public function test_asesor_can_update_password(): void
    {
        // Create an asesor user with known password
        $asesor = User::factory()->create([
            'role' => 'asesor',
            'password' => Hash::make('oldpassword123')
        ]);

        // Act as asesor and update password
        $response = $this->actingAs($asesor)
            ->put(route('asesor.pengaturan.password'), [
                'current_password' => 'oldpassword123',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        // Assert redirect back with success message
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Password berhasil diubah');

        // Verify password was changed
        $asesor->refresh();
        $this->assertTrue(Hash::check('newpassword123', $asesor->password));
        $this->assertFalse(Hash::check('oldpassword123', $asesor->password));
    }

    /**
     * Test that password update fails with incorrect current password
     */
    public function test_password_update_fails_with_wrong_current_password(): void
    {
        // Create an asesor user with known password
        $asesor = User::factory()->create([
            'role' => 'asesor',
            'password' => Hash::make('oldpassword123')
        ]);

        // Attempt to update password with wrong current password
        $response = $this->actingAs($asesor)
            ->put(route('asesor.pengaturan.password'), [
                'current_password' => 'wrongpassword',
                'password' => 'newpassword123',
                'password_confirmation' => 'newpassword123',
            ]);

        // Assert error is returned
        $response->assertRedirect();
        $response->assertSessionHasErrors('current_password');

        // Verify password was not changed
        $asesor->refresh();
        $this->assertTrue(Hash::check('oldpassword123', $asesor->password));
    }

    /**
     * Test that password update fails when confirmation doesn't match
     */
    public function test_password_update_fails_with_mismatched_confirmation(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create([
            'role' => 'asesor',
            'password' => Hash::make('oldpassword123')
        ]);

        // Attempt to update password with mismatched confirmation
        $response = $this->actingAs($asesor)
            ->put(route('asesor.pengaturan.password'), [
                'current_password' => 'oldpassword123',
                'password' => 'newpassword123',
                'password_confirmation' => 'differentpassword',
            ]);

        // Assert validation error
        $response->assertSessionHasErrors('password');

        // Verify password was not changed
        $asesor->refresh();
        $this->assertTrue(Hash::check('oldpassword123', $asesor->password));
    }

    /**
     * Test that password update requires minimum 8 characters
     */
    public function test_password_update_requires_minimum_length(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create([
            'role' => 'asesor',
            'password' => Hash::make('oldpassword123')
        ]);

        // Attempt to update with short password
        $response = $this->actingAs($asesor)
            ->put(route('asesor.pengaturan.password'), [
                'current_password' => 'oldpassword123',
                'password' => 'short',
                'password_confirmation' => 'short',
            ]);

        // Assert validation error
        $response->assertSessionHasErrors('password');

        // Verify password was not changed
        $asesor->refresh();
        $this->assertTrue(Hash::check('oldpassword123', $asesor->password));
    }

    /**
     * Test that asesor can update preferences
     */
    public function test_asesor_can_update_preferences(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create([
            'role' => 'asesor'
        ]);

        // Act as asesor and update preferences
        $response = $this->actingAs($asesor)
            ->put(route('asesor.pengaturan.preferensi'), [
                'notifikasi_email' => true,
                'bahasa' => 'id',
            ]);

        // Assert redirect back with success message
        $response->assertRedirect();
        $response->assertSessionHas('success', 'Preferensi berhasil diperbarui');
    }

    /**
     * Test that guest cannot access pengaturan page
     */
    public function test_guest_cannot_access_pengaturan_page(): void
    {
        // Attempt to access pengaturan page without authentication
        $response = $this->get(route('asesor.pengaturan'));

        // Assert redirect to login
        $response->assertRedirect(route('login'));
    }

    /**
     * Test that guest cannot update password
     */
    public function test_guest_cannot_update_password(): void
    {
        // Attempt to update password without authentication
        $response = $this->put(route('asesor.pengaturan.password'), [
            'current_password' => 'anything',
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        // Assert redirect to login
        $response->assertRedirect(route('login'));
    }
}
