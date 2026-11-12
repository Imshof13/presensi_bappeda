<?php

namespace Database\Seeders;

use App\Models\Presensi;
use App\Models\User;
use Illuminate\Database\Seeder;

class PresensiSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'user')->orderBy('id')->get();

        if ($users->isEmpty()) {
            return;
        }

        $statuses = ['hadir', 'terlambat', 'hadir', 'izin', 'sakit', 'hadir', 'terlambat'];
        $notes = [
            null,
            null,
            'Keluar 15 menit lebih cepat',
            'Mengajukan izin',
            'Sakit',
            null,
            'Terlambat karena kendala perjalanan',
        ];

        // Buat 50 data presensi. Tanggal dan user dibuat berbeda agar
        // tidak melanggar unique constraint (user_id, date).
        for ($i = 0; $i < 50; $i++) {
            $user = $users[$i % $users->count()];
            $date = now()->subDays($i)->toDateString();
            $statusIndex = $i % count($statuses);
            $status = $statuses[$statusIndex];

            $checkIn = match ($status) {
                'hadir' => ['07:05:00', '07:15:00', '07:25:00'][$i % 3],
                'terlambat' => ['07:35:00', '07:45:00', '08:00:00'][$i % 3],
                default => null,
            };

            $checkOut = in_array($status, ['hadir', 'terlambat'], true)
                ? ['16:45:00', '17:00:00', '17:10:00'][$i % 3]
                : null;

            Presensi::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'date' => $date,
                ],
                [
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'status' => $status,
                    'note' => $notes[$statusIndex],
                ]
            );
        }
    }
}
