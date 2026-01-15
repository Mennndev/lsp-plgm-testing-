<?php

namespace Tests\Feature\Admin;

use App\Models\User;
use App\Models\ProgramPelatihan;
use App\Models\UnitKompetensi;
use App\Models\ElemenKompetensi;
use App\Models\KriteriaUnjukKerja;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgramPelatihanKukTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that admin can create program pelatihan with KUK
     */
    public function test_admin_can_create_program_with_kuk(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Prepare program data with unit, elemen, and KUK
        $programData = [
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program with KUK',
            'kategori' => 'Testing',
            'jumlah_unit' => 1,
            'unit_kode' => ['UNIT-001'],
            'unit_judul' => ['Unit Kompetensi Test'],
            'elemen_nama' => [
                0 => ['Elemen Test 1', 'Elemen Test 2']
            ],
            'kuk_deskripsi' => [
                0 => [
                    0 => ['KUK 1.1', 'KUK 1.2'],
                    1 => ['KUK 2.1', 'KUK 2.2', 'KUK 2.3']
                ]
            ]
        ];

        // Act as admin and create program
        $response = $this->actingAs($admin)
            ->post(route('admin.program-pelatihan.store'), $programData);

        // Assert redirect to index
        $response->assertRedirect(route('admin.program-pelatihan.index'));
        $response->assertSessionHas('success');

        // Assert program created
        $this->assertDatabaseHas('program_pelatihans', [
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program with KUK'
        ]);

        // Get the created program
        $program = ProgramPelatihan::where('kode_skema', 'TEST-001')->first();
        
        // Assert unit created
        $this->assertEquals(1, $program->units->count());
        $unit = $program->units->first();
        $this->assertEquals('UNIT-001', $unit->kode_unit);

        // Assert elements created
        $this->assertEquals(2, $unit->elemenKompetensis->count());

        // Assert KUK created for first element
        $elemen1 = $unit->elemenKompetensis->get(0);
        $this->assertEquals(2, $elemen1->kriteriaUnjukKerja->count());
        $this->assertEquals('KUK 1.1', $elemen1->kriteriaUnjukKerja->get(0)->deskripsi);
        $this->assertEquals('KUK 1.2', $elemen1->kriteriaUnjukKerja->get(1)->deskripsi);

        // Assert KUK created for second element
        $elemen2 = $unit->elemenKompetensis->get(1);
        $this->assertEquals(3, $elemen2->kriteriaUnjukKerja->count());
        $this->assertEquals('KUK 2.1', $elemen2->kriteriaUnjukKerja->get(0)->deskripsi);
        $this->assertEquals('KUK 2.3', $elemen2->kriteriaUnjukKerja->get(2)->deskripsi);
    }

    /**
     * Test that admin can update program pelatihan with KUK
     */
    public function test_admin_can_update_program_with_kuk(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create existing program with unit and element
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-002',
            'nama' => 'Original Program',
            'slug' => 'original-program',
            'kategori' => 'Test',
            'kategori_slug' => 'test',
            'jumlah_unit' => 1,
            'is_published' => 1
        ]);

        // Update with KUK data
        $updateData = [
            'kode_skema' => 'TEST-002',
            'nama' => 'Updated Program with KUK',
            'kategori' => 'Testing',
            'jumlah_unit' => 1,
            'unit_kode' => ['UNIT-002'],
            'unit_judul' => ['Updated Unit'],
            'elemen_nama' => [
                0 => ['Updated Elemen']
            ],
            'kuk_deskripsi' => [
                0 => [
                    0 => ['Updated KUK 1', 'Updated KUK 2']
                ]
            ]
        ];

        // Act as admin and update program
        $response = $this->actingAs($admin)
            ->put(route('admin.program-pelatihan.update', $program), $updateData);

        // Assert redirect to index
        $response->assertRedirect(route('admin.program-pelatihan.index'));

        // Refresh program
        $program->refresh();

        // Assert program updated
        $this->assertEquals('Updated Program with KUK', $program->nama);

        // Assert unit and elements updated
        $this->assertEquals(1, $program->units->count());
        $unit = $program->units->first();
        $this->assertEquals('UNIT-002', $unit->kode_unit);

        // Assert KUK created
        $elemen = $unit->elemenKompetensis->first();
        $this->assertEquals(2, $elemen->kriteriaUnjukKerja->count());
        $this->assertEquals('Updated KUK 1', $elemen->kriteriaUnjukKerja->first()->deskripsi);
    }

    /**
     * Test that edit view loads KUK relationship
     */
    public function test_edit_view_loads_kuk_relationship(): void
    {
        // Create an admin user
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        // Create program with unit, element, and KUK
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-003',
            'nama' => 'Program with KUK',
            'slug' => 'program-with-kuk',
            'kategori' => 'Test',
            'kategori_slug' => 'test',
            'jumlah_unit' => 1,
            'is_published' => 1
        ]);

        $unit = UnitKompetensi::create([
            'program_pelatihan_id' => $program->id,
            'no_urut' => 1,
            'kode_unit' => 'UNIT-003',
            'judul_unit' => 'Test Unit'
        ]);

        $elemen = ElemenKompetensi::create([
            'unit_kompetensi_id' => $unit->id,
            'no_urut' => 1,
            'nama_elemen' => 'Test Elemen'
        ]);

        KriteriaUnjukKerja::create([
            'elemen_kompetensi_id' => $elemen->id,
            'no_urut' => 1,
            'deskripsi' => 'Test KUK'
        ]);

        // Act as admin and visit edit page
        $response = $this->actingAs($admin)
            ->get(route('admin.program-pelatihan.edit', $program));

        // Assert page loads successfully
        $response->assertStatus(200);

        // Assert program has KUK loaded
        $viewProgram = $response->viewData('program');
        $this->assertTrue($viewProgram->relationLoaded('units'));
        
        $loadedUnit = $viewProgram->units->first();
        $this->assertTrue($loadedUnit->relationLoaded('elemenKompetensis'));
        
        $loadedElemen = $loadedUnit->elemenKompetensis->first();
        $this->assertTrue($loadedElemen->relationLoaded('kriteriaUnjukKerja'));
        $this->assertEquals(1, $loadedElemen->kriteriaUnjukKerja->count());
        $this->assertEquals('Test KUK', $loadedElemen->kriteriaUnjukKerja->first()->deskripsi);
    }
}
