<?php

namespace Tests\Feature\Asesor;

use App\Models\User;
use App\Models\AsesorProfile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfilTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that asesor can view their profile page
     */
    public function test_asesor_can_view_profile_page(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create([
            'nama' => 'Asesor Test',
            'email' => 'asesor@test.com',
            'role' => 'asesor'
        ]);

        // Act as asesor and visit profile page
        $response = $this->actingAs($asesor)
            ->get(route('asesor.profil'));

        // Assert the page loads successfully
        $response->assertStatus(200);
        $response->assertViewHas('user');
        $response->assertViewHas('asesorProfile');
        $response->assertSee('Profil Saya');
        $response->assertSee($asesor->nama);
        $response->assertSee($asesor->email);
    }

    /**
     * Test that non-asesor cannot access asesor profile page
     */
    public function test_non_asesor_cannot_access_profile_page(): void
    {
        // Create a regular user
        $user = User::factory()->create([
            'role' => 'user'
        ]);

        // Try to access asesor profile page
        $response = $this->actingAs($user)
            ->get(route('asesor.profil'));

        // Should be redirected or forbidden
        $response->assertStatus(403);
    }

    /**
     * Test that asesor can update their profile
     */
    public function test_asesor_can_update_profile(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create([
            'nama' => 'Old Name',
            'email' => 'old@test.com',
            'role' => 'asesor'
        ]);

        // Update profile
        $response = $this->actingAs($asesor)
            ->put(route('asesor.profil.update'), [
                'nama' => 'New Name',
                'email' => 'new@test.com',
                'no_hp' => '081234567890',
                'alamat' => 'Jl. Test No. 123',
                'bidang_keahlian' => ['Teknologi Informasi', 'Manajemen'],
            ]);

        // Should redirect back to profile page
        $response->assertRedirect(route('asesor.profil'));
        $response->assertSessionHas('success');

        // Check database
        $asesor->refresh();
        $this->assertEquals('New Name', $asesor->nama);
        $this->assertEquals('new@test.com', $asesor->email);
        $this->assertEquals('081234567890', $asesor->no_hp);
        $this->assertEquals('Jl. Test No. 123', $asesor->alamat);

        // Check asesor profile
        $this->assertDatabaseHas('asesor_profiles', [
            'user_id' => $asesor->id,
            'alamat' => 'Jl. Test No. 123',
        ]);

        $asesorProfile = $asesor->asesorProfile;
        $this->assertNotNull($asesorProfile);
        $this->assertEquals(['Teknologi Informasi', 'Manajemen'], $asesorProfile->bidang_keahlian);
    }

    /**
     * Test that asesor can upload profile photo
     */
    public function test_asesor_can_upload_profile_photo(): void
    {
        Storage::fake('public');

        // Create an asesor user
        $asesor = User::factory()->create([
            'role' => 'asesor'
        ]);

        // Create fake image
        $file = UploadedFile::fake()->image('profile.jpg', 500, 500);

        // Upload photo
        $response = $this->actingAs($asesor)
            ->put(route('asesor.profil.update'), [
                'nama' => $asesor->nama,
                'email' => $asesor->email,
                'foto_profile' => $file,
            ]);

        // Should redirect back to profile page
        $response->assertRedirect(route('asesor.profil'));

        // Check that file was stored
        $asesorProfile = $asesor->fresh()->asesorProfile;
        $this->assertNotNull($asesorProfile);
        $this->assertNotNull($asesorProfile->foto_profile);
        Storage::disk('public')->assertExists($asesorProfile->foto_profile);
    }

    /**
     * Test that old profile photo is deleted when uploading new one
     */
    public function test_old_profile_photo_is_deleted_when_uploading_new(): void
    {
        Storage::fake('public');

        // Create an asesor user with existing profile photo
        $asesor = User::factory()->create([
            'role' => 'asesor'
        ]);

        // Create old photo
        $oldFile = UploadedFile::fake()->image('old.jpg');
        $oldPath = $oldFile->store('asesor/profiles', 'public');
        
        AsesorProfile::create([
            'user_id' => $asesor->id,
            'foto_profile' => $oldPath,
        ]);

        // Upload new photo
        $newFile = UploadedFile::fake()->image('new.jpg');
        
        $response = $this->actingAs($asesor)
            ->put(route('asesor.profil.update'), [
                'nama' => $asesor->nama,
                'email' => $asesor->email,
                'foto_profile' => $newFile,
            ]);

        // Should redirect back to profile page
        $response->assertRedirect(route('asesor.profil'));

        // Check that old file was deleted
        Storage::disk('public')->assertMissing($oldPath);

        // Check that new file exists
        $asesorProfile = $asesor->fresh()->asesorProfile;
        $this->assertNotNull($asesorProfile->foto_profile);
        $this->assertNotEquals($oldPath, $asesorProfile->foto_profile);
        Storage::disk('public')->assertExists($asesorProfile->foto_profile);
    }

    /**
     * Test validation for required fields
     */
    public function test_profile_update_validation(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create([
            'role' => 'asesor'
        ]);

        // Try to update with invalid data
        $response = $this->actingAs($asesor)
            ->put(route('asesor.profil.update'), [
                'nama' => '',  // Required field
                'email' => 'not-an-email',  // Invalid email
            ]);

        // Should return with validation errors
        $response->assertSessionHasErrors(['nama', 'email']);
    }

    /**
     * Test email uniqueness validation
     */
    public function test_email_must_be_unique(): void
    {
        // Create another user with email
        $otherUser = User::factory()->create([
            'email' => 'taken@test.com'
        ]);

        // Create an asesor user
        $asesor = User::factory()->create([
            'role' => 'asesor',
            'email' => 'asesor@test.com'
        ]);

        // Try to update with taken email
        $response = $this->actingAs($asesor)
            ->put(route('asesor.profil.update'), [
                'nama' => $asesor->nama,
                'email' => 'taken@test.com',
            ]);

        // Should return with validation error
        $response->assertSessionHasErrors(['email']);

        // Should allow keeping own email
        $response = $this->actingAs($asesor)
            ->put(route('asesor.profil.update'), [
                'nama' => $asesor->nama,
                'email' => 'asesor@test.com',
            ]);

        // Should be successful
        $response->assertRedirect(route('asesor.profil'));
        $response->assertSessionHasNoErrors();
    }

    /**
     * Test that profile is created if it doesn't exist
     */
    public function test_profile_is_created_if_not_exists(): void
    {
        // Create an asesor user without profile
        $asesor = User::factory()->create([
            'role' => 'asesor'
        ]);

        // Ensure no profile exists
        $this->assertNull($asesor->asesorProfile);

        // Update profile
        $response = $this->actingAs($asesor)
            ->put(route('asesor.profil.update'), [
                'nama' => $asesor->nama,
                'email' => $asesor->email,
                'bidang_keahlian' => ['Test'],
            ]);

        // Should be successful
        $response->assertRedirect(route('asesor.profil'));

        // Check that profile was created
        $asesor->refresh();
        $this->assertNotNull($asesor->asesorProfile);
    }
}
