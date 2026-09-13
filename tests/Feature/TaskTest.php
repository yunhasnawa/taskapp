<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_pengguna_melihat_daftar_tugasnya_sendiri(): void
    {
        $budi = User::factory()->create();
        $siti = User::factory()->create();
        Task::factory()->for($budi)->create(['title' => 'Laporan Budi']);
        Task::factory()->for($siti)->create(['title' => 'Laporan Siti']);

        $this->actingAs($budi)
            ->get(route('tasks.index'))
            ->assertOk()
            ->assertSee('Laporan Budi')
            ->assertDontSee('Laporan Siti');
    }

    public function test_pengguna_membuat_tugas(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();

        $this->actingAs($user)->post(route('tasks.store'), [
            'title' => 'Tugas Baru',
            'description' => 'Deskripsi',
            'priority' => 'tinggi',
            'status' => 'belum dimulai',
            'due_date' => '2026-12-31',
            'category_id' => $category->id,
        ])->assertRedirect();

        $this->assertDatabaseHas('tasks', [
            'title' => 'Tugas Baru',
            'user_id' => $user->id,
        ]);
    }

    public function test_validasi_menolak_data_tidak_valid(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('tasks.create'))
            ->post(route('tasks.store'), [
                'title' => '',
                'priority' => 'sangat tinggi',
                'status' => 'belum dimulai',
                'due_date' => 'bukan-tanggal',
            ])
            ->assertRedirect(route('tasks.create'))
            ->assertSessionHasErrors(['title', 'priority', 'due_date']);
    }

    public function test_pengguna_tidak_bisa_membuka_tugas_orang_lain(): void
    {
        $budi = User::factory()->create();
        $siti = User::factory()->create();
        $tugasSiti = Task::factory()->for($siti)->create();

        $this->actingAs($budi)->get(route('tasks.show', $tugasSiti))->assertForbidden();
        $this->actingAs($budi)->get(route('tasks.edit', $tugasSiti))->assertForbidden();
        $this->actingAs($budi)->delete(route('tasks.destroy', $tugasSiti))->assertForbidden();
    }

    public function test_tamu_diarahkan_ke_login(): void
    {
        $this->get(route('tasks.index'))->assertRedirect(route('login'));
    }

    public function test_filter_status_dan_prioritas(): void
    {
        $user = User::factory()->create();
        Task::factory()->for($user)->create(['title' => 'Sudah Kelar', 'status' => 'selesai', 'priority' => 'rendah']);
        Task::factory()->for($user)->create(['title' => 'Masih Jalan', 'status' => 'dikerjakan', 'priority' => 'tinggi']);

        $this->actingAs($user)
            ->get(route('tasks.index', ['status' => 'selesai']))
            ->assertSee('Sudah Kelar')
            ->assertDontSee('Masih Jalan');

        $this->actingAs($user)
            ->get(route('tasks.index', ['search' => 'Kelar']))
            ->assertSee('Sudah Kelar')
            ->assertDontSee('Masih Jalan');
    }

    public function test_ubah_status_cepat(): void
    {
        $user = User::factory()->create();
        $task = Task::factory()->for($user)->create(['status' => 'belum dimulai']);

        $this->actingAs($user)
            ->patch(route('tasks.status', $task), ['status' => 'selesai'])
            ->assertRedirect();

        $this->assertSame('selesai', $task->fresh()->status);
    }

    public function test_hanya_admin_yang_bisa_membuka_halaman_admin(): void
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)->get(route('admin.tasks.index'))->assertForbidden();
        $this->actingAs($admin)->get(route('admin.tasks.index'))->assertOk();
        $this->actingAs($admin)->get(route('admin.categories.index'))->assertOk();
    }
}
