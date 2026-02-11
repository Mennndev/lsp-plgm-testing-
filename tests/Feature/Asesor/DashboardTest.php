<?php

namespace Tests\Feature\Asesor;

use App\Models\User;
use App\Models\PengajuanSkema;
use App\Models\ProgramPelatihan;
use App\Models\PengajuanAsesor;
use App\Models\UnitKompetensi;
use App\Models\ElemenKompetensi;
use App\Models\KriteriaUnjukKerja;
use App\Models\PengajuanAsesorAssessment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that asesor dashboard loads successfully
     */
    public function test_asesor_dashboard_loads_successfully(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create([
            'nama' => 'Asesor User',
            'email' => 'asesor@test.com',
            'role' => 'asesor'
        ]);

        // Act as asesor and visit dashboard
        $response = $this->actingAs($asesor)
            ->get(route('asesor.dashboard'));

        // Assert the page loads successfully
        $response->assertStatus(200);
        $response->assertViewHas('summary');
        $response->assertViewHas('pengajuanList');
    }

    /**
     * Test that summary is calculated before filters
     */
    public function test_summary_calculated_before_filters(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create(['role' => 'asesor']);
        
        // Create a user (asesi)
        $asesi = User::factory()->create(['nama' => 'Test Asesi']);

        // Create a program
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program',
            'slug' => 'test-program',
            'kategori' => 'Test',
            'kategori_slug' => 'test',
            'is_published' => 1
        ]);

        // Create two pengajuan skema
        $pengajuan1 = PengajuanSkema::create([
            'user_id' => $asesi->id,
            'program_pelatihan_id' => $program->id,
            'status' => 'approved',
            'tanggal_pengajuan' => now(),
        ]);

        $pengajuan2 = PengajuanSkema::create([
            'user_id' => $asesi->id,
            'program_pelatihan_id' => $program->id,
            'status' => 'pending',
            'tanggal_pengajuan' => now(),
        ]);

        // Assign both to asesor
        PengajuanAsesor::create([
            'pengajuan_skema_id' => $pengajuan1->id,
            'asesor_id' => $asesor->id,
            'role' => 'utama'
        ]);

        PengajuanAsesor::create([
            'pengajuan_skema_id' => $pengajuan2->id,
            'asesor_id' => $asesor->id,
            'role' => 'utama'
        ]);

        // Visit dashboard without filter
        $responseAll = $this->actingAs($asesor)
            ->get(route('asesor.dashboard'));
        
        // Visit dashboard with filter (only belum_dimulai)
        $responseFiltered = $this->actingAs($asesor)
            ->get(route('asesor.dashboard', ['status_penilaian' => 'belum_dimulai']));

        // Summary should be the same in both cases (before filter)
        $summaryAll = $responseAll->viewData('summary');
        $summaryFiltered = $responseFiltered->viewData('summary');

        $this->assertEquals($summaryAll['total_penugasan'], $summaryFiltered['total_penugasan']);
        $this->assertEquals(2, $summaryFiltered['total_penugasan']);
    }

    /**
     * Test that pagination is applied
     */
    public function test_pagination_is_applied(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create(['role' => 'asesor']);
        
        // Create a user (asesi)
        $asesi = User::factory()->create(['nama' => 'Test Asesi']);

        // Create a program
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program',
            'slug' => 'test-program',
            'kategori' => 'Test',
            'kategori_slug' => 'test',
            'is_published' => 1
        ]);

        // Create 15 pengajuan skema (more than per page limit of 10)
        for ($i = 1; $i <= 15; $i++) {
            $pengajuan = PengajuanSkema::create([
                'user_id' => $asesi->id,
                'program_pelatihan_id' => $program->id,
                'status' => 'approved',
                'tanggal_pengajuan' => now(),
            ]);

            PengajuanAsesor::create([
                'pengajuan_skema_id' => $pengajuan->id,
                'asesor_id' => $asesor->id,
                'role' => 'utama'
            ]);
        }

        // Visit dashboard
        $response = $this->actingAs($asesor)
            ->get(route('asesor.dashboard'));

        // Assert pagination is applied
        $pengajuanList = $response->viewData('pengajuanList');
        
        // Should be instance of paginator
        $this->assertInstanceOf(\Illuminate\Pagination\LengthAwarePaginator::class, $pengajuanList);
        
        // Should have 10 items per page
        $this->assertEquals(10, $pengajuanList->count());
        
        // Should have 15 total items
        $this->assertEquals(15, $pengajuanList->total());
    }

    /**
     * Test that status changes based on assessment progress
     */
    public function test_status_changes_based_on_assessment_progress(): void
    {
        // Create an asesor user
        $asesor = User::factory()->create(['role' => 'asesor']);
        
        // Create a user (asesi)
        $asesi = User::factory()->create(['nama' => 'Test Asesi']);

        // Create a program with unit and KUK
        $program = ProgramPelatihan::create([
            'kode_skema' => 'TEST-001',
            'nama' => 'Test Program',
            'slug' => 'test-program',
            'kategori' => 'Test',
            'kategori_slug' => 'test',
            'is_published' => 1
        ]);

        $unit = UnitKompetensi::create([
            'program_pelatihan_id' => $program->id,
            'kode_unit' => 'UK-001',
            'judul_unit' => 'Test Unit',
            'no_urut' => 1
        ]);

        $elemen = ElemenKompetensi::create([
            'unit_kompetensi_id' => $unit->id,
            'nama_elemen' => 'Test Elemen',
            'no_urut' => 1
        ]);

        $kuk = KriteriaUnjukKerja::create([
            'elemen_kompetensi_id' => $elemen->id,
            'no_urut' => 1,
            'deskripsi' => 'Test KUK'
        ]);

        // Create pengajuan skema
        $pengajuan = PengajuanSkema::create([
            'user_id' => $asesi->id,
            'program_pelatihan_id' => $program->id,
            'status' => 'approved',
            'tanggal_pengajuan' => now(),
        ]);

        PengajuanAsesor::create([
            'pengajuan_skema_id' => $pengajuan->id,
            'asesor_id' => $asesor->id,
            'role' => 'utama'
        ]);

        // Visit dashboard - should show belum_dimulai status
        $response = $this->actingAs($asesor)
            ->get(route('asesor.dashboard'));

        $response->assertStatus(200);
        $pengajuanList = $response->viewData('pengajuanList');
        $this->assertEquals('belum_dimulai', $pengajuanList->first()['status_penilaian']);

        // Add partial assessment - should show proses status
        PengajuanAsesorAssessment::create([
            'pengajuan_skema_id' => $pengajuan->id,
            'kriteria_unjuk_kerja_id' => $kuk->id,
            'asesor_id' => $asesor->id,
            'nilai' => 'K',
            'catatan' => 'Test'
        ]);

        $responseProses = $this->actingAs($asesor)
            ->get(route('asesor.dashboard'));

        $responseProses->assertStatus(200);
        $pengajuanListProses = $responseProses->viewData('pengajuanList');
        $this->assertEquals('selesai', $pengajuanListProses->first()['status_penilaian']);
    }
}
