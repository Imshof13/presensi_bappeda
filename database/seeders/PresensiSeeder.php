<?php

namespace Database\Seeders;

use App\Models\Presensi;
use App\Models\User;
use Illuminate\Database\Seeder;

class PresensiSeeder extends Seeder
{
    //
    public function run(): void
    {
        $imshof = User::where('username', 'imshof')->first();
        $yuslih = User::where('username', 'yuslih')->first();
        $rahmat = User::where('username', 'rahmat')->first();

        // Presensi imshof

        Presensi::create([
            'user_id' => $imshof->id,
            'date' => '2026-09-14',
            'check_in' => '07:15:00',
            'check_out' => '17:00:00',
            'status' => 'hadir',
            'note' => null,
        ]);

        Presensi::create([
            'user_id' => $imshof->id,
            'date' => '2026-09-15',
            'check_in' => '07:45:00',
            'check_out' => '17:00:00',
            'status' => 'terlambat',
            'note' => null,
        ]);

        Presensi::create([
            'user_id' => $imshof->id,
            'date' => '2026-09-16',
            'check_in' => '07:20:00',
            'check_out' => '16:45:00',
            'status' => 'hadir',
            'note' => 'Keluar 15 menit lebih cepat',
        ]);

        Presensi::create([
            'user_id' => $imshof->id,
            'date' => '2026-09-17',
            'check_in' => null,
            'check_out' => null,
            'status' => 'izin',
            'note' => 'Mengajukan izin',
        ]);

        // Presensi Yuslih

        Presensi::create([
            'user_id' => $yuslih->id,
            'date' => '2026-09-14',
            'check_in' => '07:10:00',
            'check_out' => '17:00:00',
            'status' => 'hadir',
            'note' => null,
        ]);

        Presensi::create([
            'user_id' => $yuslih->id,
            'date' => '2026-09-15',
            'check_in' => '07:50:00',
            'check_out' => '17:10:00',
            'status' => 'terlambat',
            'note' => 'Keluar lebih lama 10 menit',
        ]);

        Presensi::create([
            'user_id' => $yuslih->id,
            'date' => '2026-09-16',
            'check_in' => null,
            'check_out' => null,
            'status' => 'sakit',
            'note' => 'Sakit',
        ]);

        Presensi::create([
            'user_id' => $yuslih->id,
            'date' => '2026-09-17',
            'check_in' => '07:25:00',
            'check_out' => '17:00:00',
            'status' => 'hadir',
            'note' => null,
        ]);

        // Presensi Rahmat

        Presensi::create([
            'user_id' => $rahmat->id,
            'date' => '2026-09-14',
            'check_in' => '07:20:00',
            'check_out' => '17:00:00',
            'status' => 'hadir',
            'note' => null,
        ]);

        Presensi::create([
            'user_id' => $rahmat->id,
            'date' => '2026-09-15',
            'check_in' => '07:35:00',
            'check_out' => '17:00:00',
            'status' => 'terlambat',
            'note' => null,
        ]);

        Presensi::create([
            'user_id' => $rahmat->id,
            'date' => '2026-09-16',
            'check_in' => null,
            'check_out' => null,
            'status' => 'izin',
            'note' => 'Keperluan pribadi',
        ]);

        Presensi::create([
            'user_id' => $rahmat->id,
            'date' => '2026-09-17',
            'check_in' => '07:15:00',
            'check_out' => '17:00:00',
            'status' => 'hadir',
            'note' => null,
        ]);
    }
}