<?php

namespace Tests\Feature\Admin;

use App\Models\AsesorProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AsesorControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that an admin can create an asesor with profile.
     */
    public function test_admin_can_create_asesor_with_profile(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Act as admin
        $this->actingAs($admin);

        // Create asesor data
        $asesorData = [
            'nama' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Test No. 123',
            'status_aktif' => true,
        ];

        // Submit form
        $response = $this->post(route('admin.asesor.store'), $asesorData);

        // Assert redirect
        $response->assertRedirect(route('admin.asesor.index'));
        $response->assertSessionHas('success');

        // Assert user was created
        $this->assertDatabaseHas('users', [
            'nama' => 'John Doe',
            'email' => 'john.doe@example.com',
            'role' => 'asesor',
        ]);

        // Assert profile was created
        $user = User::where('email', 'john.doe@example.com')->first();
        $this->assertNotNull($user);

        $this->assertDatabaseHas('asesor_profiles', [
            'user_id' => $user->id,
            'alamat' => 'Jl. Test No. 123',
        ]);
    }

    /**
     * Test that an admin can update an asesor profile.
     */
    public function test_admin_can_update_asesor_profile(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create asesor with profile
        $asesor = User::factory()->create([
            'role' => 'asesor',
            'nama' => 'Jane Doe',
            'email' => 'jane@example.com',
        ]);

        $profile = AsesorProfile::create([
            'user_id' => $asesor->id,
            'alamat' => 'Old Address',
        ]);

        // Act as admin
        $this->actingAs($admin);

        // Update asesor data
        $updateData = [
            'nama' => 'Jane Smith',
            'email' => 'jane@example.com',
            'no_hp' => '081234567890',
            'alamat' => 'New Address Updated',
            'status_aktif' => true,
        ];

        // Submit update
        $response = $this->put(route('admin.asesor.update', $asesor->id), $updateData);

        // Assert redirect
        $response->assertRedirect(route('admin.asesor.index'));
        $response->assertSessionHas('success');

        // Assert user was updated
        $this->assertDatabaseHas('users', [
            'id' => $asesor->id,
            'nama' => 'Jane Smith',
        ]);

        // Assert profile was updated
        $this->assertDatabaseHas('asesor_profiles', [
            'user_id' => $asesor->id,
            'alamat' => 'New Address Updated',
        ]);
    }

    /**
     * Test that deleting asesor cascades to profile.
     */
    public function test_deleting_asesor_cascades_to_profile(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create asesor with profile
        $asesor = User::factory()->create([
            'role' => 'asesor',
        ]);

        $profile = AsesorProfile::create([
            'user_id' => $asesor->id,
            'alamat' => 'Test Address',
        ]);

        // Act as admin
        $this->actingAs($admin);

        // Delete asesor
        $response = $this->delete(route('admin.asesor.destroy', $asesor->id));

        // Assert redirect
        $response->assertRedirect(route('admin.asesor.index'));

        // Assert user was deleted
        $this->assertDatabaseMissing('users', [
            'id' => $asesor->id,
        ]);

        // Assert profile was deleted (cascade)
        $this->assertDatabaseMissing('asesor_profiles', [
            'user_id' => $asesor->id,
        ]);
    }

    /**
     * Test that asesor index eager loads profiles.
     */
    public function test_asesor_index_loads_profiles(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create asesor with profile
        $asesor = User::factory()->create([
            'role' => 'asesor',
        ]);

        $profile = AsesorProfile::create([
            'user_id' => $asesor->id,
            'alamat' => 'Test Address',
        ]);

        // Act as admin
        $this->actingAs($admin);

        // View index
        $response = $this->get(route('admin.asesor.index'));

        // Assert success
        $response->assertStatus(200);
        $response->assertViewHas('asesors');
    }

    /**
     * Test validation errors are returned on empty form submission.
     */
    public function test_validation_errors_on_empty_form(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Act as admin
        $this->actingAs($admin);

        // Submit empty form
        $response = $this->post(route('admin.asesor.store'), []);

        // Assert validation errors
        $response->assertSessionHasErrors(['nama', 'email', 'password', 'no_hp']);
    }

    /**
     * Test duplicate email validation error.
     */
    public function test_duplicate_email_validation_error(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Create existing asesor with email
        $existingAsesor = User::factory()->create([
            'email' => 'existing@example.com',
            'role' => 'asesor',
        ]);

        // Act as admin
        $this->actingAs($admin);

        // Try to create asesor with duplicate email
        $response = $this->post(route('admin.asesor.store'), [
            'nama' => 'New Asesor',
            'email' => 'existing@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'no_hp' => '081234567890',
        ]);

        // Assert validation error for email
        $response->assertSessionHasErrors(['email']);
    }

    /**
     * Test password minimum length validation.
     */
    public function test_password_minimum_length_validation(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Act as admin
        $this->actingAs($admin);

        // Submit with short password
        $response = $this->post(route('admin.asesor.store'), [
            'nama' => 'Test Asesor',
            'email' => 'test@example.com',
            'password' => 'pass',
            'password_confirmation' => 'pass',
            'no_hp' => '081234567890',
        ]);

        // Assert validation error for password
        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test password confirmation mismatch validation.
     */
    public function test_password_confirmation_mismatch(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Act as admin
        $this->actingAs($admin);

        // Submit with mismatched passwords
        $response = $this->post(route('admin.asesor.store'), [
            'nama' => 'Test Asesor',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'differentpass',
            'no_hp' => '081234567890',
        ]);

        // Assert validation error for password
        $response->assertSessionHasErrors(['password']);
    }

    /**
     * Test create form displays validation errors.
     */
    public function test_create_form_shows_validation_errors(): void
    {
        // Create admin user
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        // Act as admin
        $this->actingAs($admin);

        // Submit invalid data
        $response = $this->from(route('admin.asesor.create'))
            ->post(route('admin.asesor.store'), [
                'nama' => '',
                'email' => 'invalid-email',
            ]);

        // Assert redirect back to form
        $response->assertRedirect(route('admin.asesor.create'));
        $response->assertSessionHasErrors();

        // Follow redirect and check view
        $response = $this->get(route('admin.asesor.create'));
        $response->assertStatus(200);
    }
}
