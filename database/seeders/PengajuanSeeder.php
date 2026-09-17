<?php

namespace Database\Seeders;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengajuanSeeder extends Seeder
{
    public function run(): void
    {
        $imshof = User::where('username', 'imshof')->first();
        $yuslis = User::where('username', 'yuslih')->first();
        $rahmat = User::where('username', 'rahmat')->first();
        $admin = User::where('username', 'admin')->first();

        // Pengajuan Imshof
        Pengajuan::create([
            'user_id' => $imshof->id,
            'tanggal' => '2026-09-17',
            'mengajukan' => 'izin',
            'alasan' => 'Ada keperluan keluarga.',
            'bukti' => null,
            'status' => 'pending',
            'dicek_oleh' => null,
            'dicek_saat' => null,
        ]);

        // Pengajuan Yuslih
        Pengajuan::create([
            'user_id' => $yuslis->id,
            'tanggal' => '2026-09-16',
            'mengajukan' => 'sakit',
            'alasan' => 'Sedang kurang sehat.',
            'bukti' => null,
            'status' => 'diterima',
            'dicek_oleh' => $admin->id,
            'dicek_saat' => '2026-09-16 08:00:00',
        ]);

        // Pengajuan Rahmat
        Pengajuan::create([
            'user_id' => $rahmat->id,
            'tanggal' => '2026-09-16',
            'mengajukan' => 'izin',
            'alasan' => 'Ada keperluan pribadi.',
            'bukti' => null,
            'status' => 'ditolak',
            'dicek_oleh' => $admin->id,
            'dicek_saat' => '2026-09-16 08:15:00',
        ]);
    }
}